<?php

namespace app\models;

use app\components\helpers\CommonHelper;
use yii;
use app\components\extend\ActiveRecord;

/**
 * This is the model class for table "{{%user_passport}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $serial_nr
 * @property string $issued_by
 * @property integer $issued_date
 * @property string $division_code
 * @property string $place_of_birth
 * @property string $place_of_residence
 * @property string $verify
 * @property string $scan_passport
 * @property string $request_id
 * @property string $is_scorista_wait
 *
 * @property User $user
 * @method Files getFile(string $attribute) get file
 */
class UserPassport extends ActiveRecord
{
	//verification	
	const VERIFY_WAIT = 0;
	const VERIFY_VERIFIED = 1;
	const VERIFY_UNVERIFIED = 2;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_passport}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => behaviors\common\SaveFilesBehavior::className(),
				'fileAttributes' => ['scan_passport']
			]
		] + parent::behaviors();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'issued_date', 'serial_nr', 'issued_by', 'division_code', 'place_of_birth', 'place_of_residence'], 'required'],
            ['serial_nr', 'validateSerial'],
            ['division_code', 'validateDivcode'],
			[['request_id','is_scorista_wait'], 'safe'],
			[['user_id', 'verify','is_scorista_wait'], 'integer'],
			[['serial_nr', 'issued_by', 'division_code', 'place_of_birth', 'place_of_residence'], 'string', 'max' => 255],
			[['scan_passport'], 'file', 'skipOnEmpty' => true, 'maxSize' => Files::imageMaxSize(), 'extensions' => Files::imageExtension(), 'maxFiles' => 1],
            [['issued_date', 'serial_nr', 'issued_by', 'division_code', 'place_of_birth', 'place_of_residence'], 'required', 'on' => 'update'],
            //['issued_date', 'validateToIssuedate', 'on' => 'update'],

		];
	}

    public function validateSerial($attribute, $params)
    {
        if (!preg_match ('/^\d{4}-\d{6}$/u', $this->$attribute)) {
            $this->addError($attribute, 'Серия и номер паспорта должны быть корректно заполнены, пример: 1234-123456');
        }
    }

    public function validateDivcode($attribute, $params)
    {
        if (!preg_match ('/^\d{3}-\d{3}$/u', $this->$attribute)) {
            $this->addError($attribute, 'Код подразделения должен быть корректно заполнен, пример: 123-456');
        }
    }

    public function validateToIssuedate($attribute, $params)
    {
        $issueday = new \DateTime(date('Y-m-d', $this->$attribute));
        $now = new \DateTime();
        $age = $issueday->diff($now);

        //$this->addError($attribute, $age->y.'Паспорт РФ выдается в возрасте 14 лет.');

        //$def = date('Y',$this->$attribute)-date('Y',(strtotime('now')));//1493371471-1265144400
        if($age->y<2){
            $this->addError($attribute, $age->y.'Паспорт РФ выдается в возрасте 14 лет.');
        }

    }
	/**
	 * @param integer $verify
	 * @return mixed
	 */
	public static function getVerfiyLabels($verify = false)
	{
		$ar = [
			self::VERIFY_VERIFIED   => 'Верифицирован',
			self::VERIFY_UNVERIFIED => 'Не верифицирован',
		];

		if ($verify !== false) {
			if (isset($ar[$verify])) {
				return $ar[$verify];
			} else {
				return 'Неизвестно';
			}
		} else {
			return $ar;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'                 => 'ID',
			'user_id'            => 'User ID',
			'serial_nr'          => 'Серия и номер паспорта',
			'issued_by'          => 'Кем выдан',
			'issued_date'        => 'Дата выдачи',
			'division_code'      => 'Код подразделения',
			'place_of_birth'     => 'Место рождения',
			'place_of_residence' => 'Адрес прописки',
			'verify' => 'Верфицирован?',
			'scan_passport' => 'Скан паспорт',
			'request_id' => 'Запрос ID',
			'is_scorista_wait' => 'Ожидание запроса',
		];
	}

	public function beforeValidate()
	{
		$this->convertIssuedDateToUnix();

		return parent::beforeValidate(); // TODO: Change the autogenerated stub
	}

	/**
	 * @inheritdoc
	 */
	public function convertIssuedDateToUnix()
	{
		if (!is_numeric($this->issued_date) && $this->issued_date != '') {
			$this->issued_date = strtotime($this->issued_date);
		}
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	public function getScanUrl($options = [])
	{
		return $this->getFile('scan_passport')->getImageUrl($options);
	}

	public function deleteScan()
	{
		return $this->getFile('scan_passport')->deleteFile();
	}

	public static function setInvalid($uid=null)
	{
		if($uid==null){
			$user = User::findOne(yii::$app->user->id);
		}else{
			$user = User::findOne($uid);
		}
		yii::$app->mailer->compose('verify-invalid', [
			//'report' => $this,
		])->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo($user->email)
			->setSubject('Ваши данные не прошли верификацию на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}

	public static function setValid($uid=null)
	{
		if($uid==null){
			$user = User::findOne(yii::$app->user->id);
		}else{
			$user = User::findOne($uid);
		}

		yii::$app->mailer->compose('verify-valid', [
			//'report' => $this,
		])->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo($user->email)
			->setSubject('Вы успешно прошли верификацию на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}

	public static function setVerify($uid=null)
	{
		if($uid==null){
			$user = User::findOne(yii::$app->user->id);
		}else{
			$user = User::findOne($uid);
		}
		yii::$app->mailer->compose('verify', [
			//'report' => $this,
		])->setFrom(CommonHelper::data()->getParam('supportEmail'))
			->setTo($user->email)
			->setSubject('Запрос на верификацию на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
			->send();
	}

}
