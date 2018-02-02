<?php

namespace app\models;

use app\components\helpers\CommonHelper;
use app\components\ScoristaAPI;
use yii\behaviors\TimestampBehavior;
use yii;

/**
 * This is the model class for table "{{%screening_report}}".
 *
 * ScreeningReport model
 *
 * @property integer $type
 * @property string $name_first
 * @property string $name_last
 * @property string $name_middle
 * @property string $birthday
 * @property string $phone
 * @property string $address
 * @property string $post_code
 * @property string $insurance
 * @property string $comment
 * @property string $document
 * @property string $status
 * @property string $report_date
 * @property string $request_id
 * @property string $result
 * @property string $is_scorista_wait
 * @property User $user
 *
 */
class ScreeningReport extends \app\components\extend\ActiveRecord
{
	const TYPE_CREDIT = 1;
	const TYPE_BIO = 2;
	const STATUS_PENDING = 1;
	const STATUS_VALID = 2;
	const STATUS_INVALID = 3;
	const SCENARIO_SEND = 'send';
	const SCENARIO_VALID = 'valid';
	const SCENARIO_INVALID = 'invalid';
	
	public $accept_terms;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%screening_report}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['type'], 'required', 'message' => 'Выберите как минимум одну опцию.'],
			[['accept_terms'], 'required', 'message' => 'Вы должны подтвердить согласие на обработку данных.'],
			[['accept_terms'], 'boolean'],
			[['name_first', 'name_last', 'name_middle', 'birthday', 'phone', 'address', 'post_code', 'insurance', 'comment'], 'required'],
			[['birthday'], 'date', 'format' => 'dd.MM.yyyy'],
			[['name_first', 'name_last', 'name_middle', 'phone'], 'string', 'max' => 100],
			[['address'], 'string', 'max' => 250],
			[['post_code'], 'string', 'max' => 10],
			[['insurance'], 'string', 'max' => 50],
			[['post_code'], 'match', 'pattern' => '/^[0-9]+$/'],
			[['insurance'], 'match', 'pattern' => '/^([0-9]{1,3})[-]([0-9]{1,3})[-]([0-9]{1,3})[-]([0-9]{1,2})+$/'],
			[['document'], 'file', 'maxFiles' => 1, 'skipOnEmpty' => true, 'extensions' => ['pdf'], 'checkExtensionByMimeType' => false],
			[['result','is_scorista_wait'], 'safe'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			self::SCENARIO_DEFAULT => ['type', 'name_first', 'name_last', 'name_middle', 'birthday', 'phone', 'address', 'post_code', 'insurance', 'accept_terms'],
			self::SCENARIO_SEND => ['name_first', 'name_last', 'name_middle', 'birthday', 'phone', 'address', 'post_code', 'insurance'],
			self::SCENARIO_INVALID => ['comment'],
			self::SCENARIO_VALID => ['document'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'report_date',
				'updatedAtAttribute' => false,
			],
			[
				'class' => behaviors\common\SaveFilesBehavior::className(),
				'fileAttributes' => ['document'],
			],
		] + parent::behaviors();
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'type' => 'Тип',
			'name_first' => 'Имя',
			'name_last' => 'Фамилия',
			'name_middle' => 'Отчество',
			'birthday' => 'Дата рождения',
			'phone' => 'Телефон',
			'address' => 'Текущий адрес прописки',
			'post_code' => 'Почтовый индекс',
			'insurance' => 'Номер страхового полиса (СНИЛС)',
			'comment' => 'Комментарий',
			'document' => 'Документ',
			'status' => 'Статус',
			'report_date' => 'Дата',
			'request_id' => 'Request ID Scorista',
			'result' => 'Резултать',
            'is_scorista_wait' => 'Ожидание запроса',
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public static function getStatusLabels()
	{
		return [
			self::STATUS_PENDING => 'Ожидает проверки',
			self::STATUS_VALID => 'Проверка пройдена',
			self::STATUS_INVALID => 'Недостоверные данные',
		];
	}
	
	public static function getTypeLabels()
	{
		return [
			self::TYPE_BIO => 'Биография',
			self::TYPE_CREDIT => 'Кредитная история',
		];
	}
	
	public function getStatusLabel()
	{
		$list = self::getStatusLabels();
		return isset($list[$this->status]) ? $list[$this->status] : 'Неизвестно';
	}
	
	public function getTypeLabel()
	{
		$list = self::getTypeLabels();
		return isset($list[$this->type]) ? $list[$this->type] : 'Неизвестно';
	}
	
	public function getDocumentUrl()
	{
		return $this->getFile('document')->getUrl();
	}
	
	public function isHandled()
	{
		return  $this->status == self::STATUS_VALID || 
				$this->status == self::STATUS_INVALID;
	}
	
	public function sendReports()
	{
		
		foreach ($this->type as $type) {
			$report = new static();
			$report->setScenario(self::SCENARIO_SEND);
			$report->attributes = $this->attributes;
			$report->type = $type;
			$report->user_id = yii::$app->user->id;
			$report->status = self::STATUS_PENDING;
			if (preg_match('#^([0-9]{1,2})[.]([0-9]{1,2})[.]([0-9]{1,4})$#', $report->birthday, $m)) {
				$report->birthday = sprintf('%s-%s-%s', $m[3], $m[2], $m[1]);
			}
			$report->save(false);
			//send request to Scorista
			$scorista = new ScoristaAPI();
			$req = $scorista->request($report->id);
            if(isset($req->status) AND $req->status=='OK'){
				$report->request_id = $req->requestid;
				$report->update(false);
			}else{
                if(isset($req->status) AND $req->status=='ERROR' AND $req->error->code==400){
                    //yii::$app->getSession()->setFlash('error', 'Данные не отправлены! Попробуйте позже.<br/>Причина: '.$req->error->message);
                }else{
                    $report->is_scorista_wait = 1;
                    $report->update(false);
                }
            }
		}
	}
	
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		if ($insert) {
			if ($this->type == self::TYPE_BIO) {
				$column = 'report_bio_id';
			} else {
				$column = 'report_credit_id';
			}
			ScreeningRequest::updateAll([
				$column => $this->id,
				'reporter_id' => $this->user_id,
			], $column . ' IS NULL AND (type = :type OR type = :typefull) AND (email = :email OR reporter_id = :reporter_id)', [
				'email' => $this->user->email,
				'reporter_id' => $this->user->id,
				'type' => $this->type,
				'typefull' => ScreeningRequest::TYPE_FULL,
			]);
		}
	}
	
	public function setInvalid()
	{
		$this->status = self::STATUS_INVALID;
		$this->save(false);
		yii::$app->mailer->compose('screening-report-invalid', [
			'report' => $this,
		])->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo($this->user->email)
			->setSubject('Ваши данные не прошли проверку на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}
	
	public function setValid()
	{
		$this->status = self::STATUS_VALID;
		$this->save(false);
		yii::$app->mailer->compose('screening-report-valid', [
			'report' => $this,
		])->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo($this->user->email)
			->setSubject('Ваши данные прошли проверку на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}
	
	public function loadFromUserData($user)
	{
		$this->name_first = $user->first_name;
		$this->name_last = $user->last_name;
		$this->name_middle = $user->middle_name;
		$this->birthday = $user->date_of_birth;
		$this->phone = $user->phone;
		if ($user->passport) {
			$this->address = $user->passport->place_of_residence;
		}
	}
	public function checkPassport(){
		$user = User::findOne(Yii::$app->user->id);
		if($user->passport==null){
			return true;
		}else{
			$passport = $user->passport;
		}
		
		//passport
		if(empty($passport->serial_nr)){ return true; }
		if(empty($passport->issued_by)){ return true; }
		if(empty($passport->issued_date)){ return true; }
		if(empty($passport->division_code)){ return true; }
		if(empty($passport->place_of_birth)){ return true; }
		if(empty($passport->place_of_residence)){ return true; }
		return false;
	}
	
	public function afterFind()
	{
		parent::afterFind(); // TODO: Change the autogenerated stub
		//check info to Scorista
		if(empty($this->result) OR $this->result==null){
			$scorista = new ScoristaAPI();
			$json = $scorista->checkRequest($this->request_id);
		}else{
			$json = json_decode($this->result);
		}

		if($json->status=='DONE'){
			$this->result = json_encode($json);
			if($this->status==self::STATUS_PENDING){
				if($json->data->decision->decisionBinnar==1){
					self::setValid();
				}else{
					self::setInvalid();
				}
			}			
			$this->update(false);
		}else{
			$this->result = json_encode($json);
		}
	}
}