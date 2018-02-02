<?php

namespace app\models;

use app\components\extend\Html;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $date_of_birth
 * @property integer $real_estate_count
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $fullName
 * @property string $data
 * @property boolean $isCustomer
 * @property boolean $isManager
 * @property boolean $feed_free_date
 * @property boolean $verify_save
 * @property boolean $not_editable
 *
 * @property UserInfo $info
 * @property UserCustomerInfo $customerInfo
 * @property Ads $ads
 * @property RealEstate[] $realEstate
 * @property UserPassport $passport
 */
class User extends \app\components\extend\ActiveRecord implements IdentityInterface
{
    public $check;
    public $verify_save;
	const SCENARIO_DELETE_ACCOUNT = 'deleteAccount';
	const SCENARIO_FIND_PARTICIPANT = 'find_participant';

	const DATA_NOTE_NEW_APPLICATION = 'data[notification][notificateAboutNewApplications]';
	const DATA_NOTE_CHECK_PERSONAL_DATA = 'data[notification][notificateAboutCheckPersonalDataAndCreditHist]';
	const DATA_NOTE_STATUS_OF_COSTUMER_CHECK = 'data[notification][notificateCostumerCeckStatus]';
	const DATA_NOTE_WHEN_CUSTOMER_PAY = 'data[notification][notificateCostumerPayment]';
	const DATA_NOTE_BEFORE_LEASE_ENDS = 'data[notification][notificateBeforeLeaseEnds]';

	const SESSION_SMS_SIGNUP_KEY = 'sign-up-sms-key';

	public $assignedRoles = [];

//    statuses
	const STATUS_DELETED = 0;
	const STATUS_DISABLED = 1;
	const STATUS_ACTIVE = 10;
//    roles
	const ROLE_ADMIN = 'admin';
	const ROLE_LESSOR = 'lessor';
	const ROLE_MANAGER = 'manager';
	const ROLE_CUSTOMER = 'customer';

	public $passwordConfirmation;
	public $deleteAccount;
	public $deleteAccountInfo;

	public function init()
	{
		parent::init();
	}

	/**
	 * @param integer /boolean $status
	 * @return type
	 */
	public function getStatusLabels($status = false)
	{
		$ar = [
			self::STATUS_ACTIVE   => 'Активен',
			self::STATUS_DISABLED => 'Не активен',
			self::STATUS_DELETED  => 'Удален',
		];
		return $status !== false ? $ar[$status] : $ar;
	}

	/**
	 * get available roles while user registration
	 * @param string $role
	 * @return type
	 */
	public function getRoleLabels($role = null)
	{
		$ar = [
			self::ROLE_ADMIN    => 'Админнистратор',
			self::ROLE_LESSOR   => 'Арендодатель',
			self::ROLE_MANAGER  => 'Менеджер',
			self::ROLE_CUSTOMER => 'Арендующий',
		];
		return $role ? $ar[$role] : $ar;
	}

	public $password;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			behaviors\user\UserDataBehavior::className(),
			behaviors\user\UserInfoBehavior::className(),
		] + parent::behaviors();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['first_name', 'email'], 'required'],
			['first_name', 'validateName'],
			[['password'], 'checkEmptyPassword', 'skipOnEmpty' => false, 'on' => self::SCENARIO_DEFAULT],
			[['status', 'created_at', 'updated_at', 'deleteAccount', 'real_estate_count'], 'integer'],
			[['username', 'first_name', 'last_name', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
			[['auth_key', 'password'], 'string', 'max' => 32],
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['role', 'default', 'value' => 1],
			[['username', 'first_name', 'last_name', 'middle_name'], 'filter', 'filter' => 'trim'],
			['username', 'unique', 'targetClass' => 'app\models\User', 'on' => self::SCENARIO_DEFAULT],
			[['username', 'first_name', 'last_name', 'phone'], 'string', 'min' => 1, 'max' => 255],
			[['email', 'deleteAccountInfo'], 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => 'app\models\User', 'on' => self::SCENARIO_DEFAULT],
			[['passwordConfirmation'], 'required', 'on' => self::SCENARIO_DELETE_ACCOUNT],
			[['passwordConfirmation', 'deleteAccountInfo', 'deleteAccount'], 'passwordConfirmationRule'],
			['password', 'string', 'min' => 6],
			[['date_of_birth', 'data', 'check', 'feed_free_date', 'verify_save', 'not_editable'], 'safe'],

			['first_name', 'required', 'on' => self::SCENARIO_FIND_PARTICIPANT],
			['first_name', 'trim', 'on' => self::SCENARIO_FIND_PARTICIPANT],
			['email', 'required', 'on' => self::SCENARIO_FIND_PARTICIPANT],
			['email', 'email', 'on' => self::SCENARIO_FIND_PARTICIPANT],
            ['email', 'validateParticipants', 'on' => self::SCENARIO_FIND_PARTICIPANT],
            ['first_name', 'required', 'on' => 'update'],
            ['last_name', 'required', 'on' => 'update'],
            ['middle_name', 'required', 'on' => 'update'],
            ['date_of_birth', 'required', 'on' => 'update'],
            ['date_of_birth', 'validateToage', 'on' => 'update'],
        ];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		$s = parent::scenarios();
		$s[self::SCENARIO_DELETE_ACCOUNT] = [
			'passwordConfirmation',
			'deleteAccount',
			'deleteAccountInfo',
		];
		return $s;
	}

    public function validateToage($attribute, $params)
    {
        $birthday = new \DateTime(date('Y-m-d', $this->$attribute));
        $now = new \DateTime();
        $age = $now->diff($birthday);
        $age->y;
        //$def = date('Y',(strtotime('now')))-date('Y',$this->$attribute);//1493371471-1265144400
        if($age->y<18){
            $this->addError($attribute, 'Возраст заемщика должен быть не менее 18 лет');
        }
    }

	public function validateName($attribute, $params)
	{
		if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
			$this->addError($attribute, 'ФИО может содержать только русские буквы');
		}
	}

    public function validateParticipants($attribute, $params)
    {
        $user = User::findByEmail($this->$attribute);
        if ($user && $user->isLessor) {
            $this->addError($attribute, 'Собственник не может быть арендатором');
        }
    }

    /**
	 * password confirmation rule
	 * @param type $attribute
	 */
	public function passwordConfirmationRule($attribute)
	{
		if ($this->scenario == self::SCENARIO_DELETE_ACCOUNT && (!$this->passwordConfirmation || trim($this->passwordConfirmation) == '' || !$this->validatePassword($this->passwordConfirmation))) {
			$this->addError('passwordConfirmation', 'Неверный пароль');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'first_name'           => 'Имя',
			'last_name'            => 'Фамилия',
			'middle_name'          => 'Отчество',
			'real_estate_count'    => 'Количество объектов недвижимости',
			'username'             => 'Логин',
			'password'             => 'Пароль',
			'email'                => 'Email',
			'role'                 => 'Роль',
			'status'               => 'Статус',
			'created_at'           => 'Добавлено',
			'updated_at'           => 'Обновлено',
			'date_of_birth'        => 'Дата рождения',
			'phone'                => 'Телефон',
			'passwordConfirmation' => 'Пароль',
            'feed_free_date'       => 'Срок беслпатный публикация',
		];
	}

	/* relations end */

	public function checkEmptyPassword($attribute, $param)
	{
		if (($this->isNewRecord || !$this->password_hash || !$this->auth_key) && trim($this->$attribute) == '') {
			$this->addError($attribute, Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $this->getAttributeLabel($attribute)]));
		}
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => trim($username), 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by ID
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findById($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by email
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByEmail($email)
	{
		return static::find()->where(['email' => trim($email), 'status' => self::STATUS_ACTIVE])->one();
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status'               => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		$parts = explode('_', $token);
		$timestamp = (int)end($parts);
		return $timestamp + $expire >= time();
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	/**
	 * encode password
	 */
	public function encodePassword()
	{
		if ($this->password && trim($this->password) != '') {
			$this->setPassword($this->password);
			$this->generateAuthKey();
		}
	}

	/**
	 *
	 * @param type $insert
	 * @return type
	 */
	public function beforeSave($insert)
	{
		$this->encodePassword();

		if ($this->role != self::ROLE_ADMIN)
			$this->role = self::ROLE_CUSTOMER;
		if ($this->scenario == self::SCENARIO_DELETE_ACCOUNT) {
			$this->status = self::STATUS_DELETED;
		}

		$this->transliterateUserName();

		return parent::beforeSave($insert);
	}

	public function beforeValidate()
	{
		$this->convertBirthDateToUnix();

		return parent::beforeValidate(); // TODO: Change the autogenerated stub
	}

	/**
	 * transliterate username
	 * @return type
	 */
	public function transliterateUserName()
	{
		if (trim($this->username) != '') {
			return $this->username;
		}
		$un = CommonHelper::str()->transliterate($this->fullName);
		$this->username = strtolower(str_replace(' ', '-', $un)) . '-' . time();
		return $this->username;
	}

	/**
	 * @inheritdoc
	 */
	public function convertBirthDateToUnix()
	{
		if (!is_numeric($this->date_of_birth) && $this->date_of_birth != '') {
			$this->date_of_birth = strtotime($this->date_of_birth);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function afterSave($insert, $changedAttributes)
	{
		$as = parent::afterSave($insert, $changedAttributes);
		$this->checkRealEstates($insert, $changedAttributes);
		$this->informAdminsAboutDeletedAccount();
		return $as;
	}

    /**
     * Проверяем изменилось ли ФИО и нужно ли заново проверять объекты
     * @param $insert
     * @param $changedAttributes
     */
    private function checkRealEstates($insert, $changedAttributes)
    {
        if (!$insert && ($this->isChanged($changedAttributes, 'first_name') || $this->isChanged($changedAttributes, 'last_name')
                || $this->isChanged($changedAttributes, 'middle_name'))
        ) {
            foreach ($this->realEstate as $realEstate)
                $realEstate->updateAttributes(['check_status' => $this->check ? RealEstate::CHECK_STATUS_START : RealEstate::CHECK_STATUS_NOT_RUN]);
        }
    }

    /**
     * @param array $changedAttributes
     * @param string $attr
     * @return bool
     */
    private function isChanged($changedAttributes, $attr)
    {
        return isset($changedAttributes[$attr]) && trim($changedAttributes[$attr]) != trim($this->$attr);
	}

	/**
	 * send notifications to admins about account deletion
	 */
	public function informAdminsAboutDeletedAccount()
	{
		if ($this->scenario == self::SCENARIO_DELETE_ACCOUNT) {
			$this->status = self::STATUS_DELETED;

			$message = Yii::t('yii', 'Пользователь {user} удалил свой аккаунт! На данный момент запись ещё присутствует в системе. Для полного удаления вам придётся перейти в раздел управления пользователями и удалить запись вручную.', [
				'user' => $this->getFullName([
					'class' => 'btn btn-link',
					'style' => 'color:#337ab7',
				], true),
			]);

			if (trim(strip_tags($this->deleteAccountInfo)) != '') {
				$message .= Html::tag('h5', 'Пользователь написал при этом:');
				$message .= $this->deleteAccountInfo;
			}

			Notifications::messageAdmins($message);
		}
	}

	/**
	 * get user full name
	 * @param array $options if options are set function will return link
	 * @return string
	 */
	public function getFullName($options = null, $adminLink = false)
	{
		$fn = $this->first_name . ' ' . $this->last_name;
		if (trim($fn) == '') {
			$fn = $this->username;
		}
		$link = $adminLink ? ['/admin/user/view', 'id' => $this->primaryKey] : ['user', 'id' => $this->primaryKey];
		return $options ? Html::a($fn, Url::to($link), (is_array($options) ? $options : [])) : $fn;
	}
	/**
	 * get user full name fixed Ivanov Ivan Ivanovich
	 * @param array $options if options are set function will return link
	 * @return string
	 */
	public function getFullNameAll($options = null, $adminLink = false)
	{
		$fn = $this->last_name . ' ' . $this->first_name. ' ' . $this->middle_name;
		if (trim($fn) == '') {
			$fn = $this->username;
		}
		$link = $adminLink ? ['/admin/user/view', 'id' => $this->primaryKey] : ['user', 'id' => $this->primaryKey];
		return $options ? Html::a($fn, Url::to($link), (is_array($options) ? $options : [])) : $fn;
	}

	/**
	 * get all assigned roles to this user
	 * @param boolean $asString
	 * @return array
	 */
	public function getRoles($user_id = null, $asString = false)
	{
		$this->assignedRoles = count($this->assignedRoles) > 0 ? $this->assignedRoles : Yii::$app->authManager->getAssignments(((int)$user_id > 0 ? $user_id : $this->id));

		if ($asString) {
			$tmp = '';
			foreach (array_keys($this->assignedRoles) as $k => $v) {
				$tmp .= ($tmp == '' ? '' : ', ') . $this->getRoleLabels($v);
			}
			return $tmp;
		}
		return $this->assignedRoles;
	}

	/**
	 * check if this user has certain role
	 * @param string /array $role
	 * @return boolean
	 */
	public function hasRole($role)
	{
		$roles = array_keys($this->getRoles());
		$result = false;
		if (is_array($role) && is_array($roles)) {
			$result = !empty(array_intersect($roles, $role));
		}
		if (is_array($roles) && in_array($role, $roles)) {
			$result = true;
		}
		return $result;
	}

	/**
	 * Finds all users by assignment role
	 *
	 * @param  string $roleName
	 * @return \yii\db\Query
	 */
	public static function findByRole($roleName)
	{
		$role = (new \yii\rbac\Role(['name' => (string)$roleName]));
		return static::find()->join('LEFT JOIN', '{{%auth_assignment}}', '{{%auth_assignment}}.user_id::INTEGER={{%user}}.id')
			->where(['{{%auth_assignment}}.item_name' => $role->name]);
	}

	/**
	 * assign certain role for current user
	 * @param string $role
	 * @param array /string $allowed
	 */
	public function assignRole($role, $allowed = [])
	{
		if ((is_array($allowed) && array_key_exists($role, $allowed)) || ($role === $allowed)) {
			Yii::$app->authManager->assign(new \yii\rbac\Role(['name' => $role]), $this->primaryKey);
		}
	}

	/**
	 * render users avatar
	 * @param type $options
	 * @return type
	 */
	public function renderAvatar($options = [])
	{
		Html::addCssClass($options, 'user_avatar');
		if ($info = $this->loadInfo()) {
			return $info->renderPhoto($options);
		}
		return (new Files())->renderImage($options);
	}

	public function getAvatarUrl($options = [])
	{
		Html::addCssClass($options, 'user_avatar');
		if ($info = $this->loadInfo()) {
			return $info->getPhotoUrl($options);
		}
		return (new Files())->getImageUrl($options);
	}

	public function getAge()
	{
		if ($this->date_of_birth != '') {
			$birthday = new \DateTime(date('Y-m-d', $this->date_of_birth));
			$now = new \DateTime();
			$age = $now->diff($birthday);
			return $age->y;
		} else {
			return 0;
		}
	}

	public function isDataChecked()
	{ //Bio
		$request = ScreeningRequest::find()->where([
			'user_id'=>Yii::$app->user->id,
			'reporter_id'=>$this->id,
			//'type'=>ScreeningReport::TYPE_BIO,
		])->one();
		if(isset($request->report_bio_id) AND !empty($request->report_bio_id)){
			return ScreeningReport::findOne($request->report_bio_id);
		}
		return false;
	}

	public function isCreditHistoryChecked()
	{ //Credit
		$request = ScreeningRequest::find()->where([
			'user_id'=>Yii::$app->user->id,
			'reporter_id'=>$this->id,
			//'type'=>ScreeningReport::TYPE_CREDIT,
		])->one();
		if(isset($request->report_credit_id) AND !empty($request->report_credit_id)){
			return ScreeningReport::findOne($request->report_credit_id);
		}
		return false;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPassport()
	{
		return $this->hasOne(UserPassport::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRealEstate()
	{
		return $this->hasMany(RealEstate::className(), ['user_id' => 'id']);
	}

	/**
	 * @return yii\db\ActiveQuery
	 */
	public function getAds()
	{
		return $this->hasMany(Ads::className(), ['real_estate_id' => 'id'])->via('realEstate');
	}

	/**
	 *
	 * @param string $message
	 * @param integer $type default : Notifications::TYPE_NOTIFICATION
	 * @return Notifications
	 */
	public function message($message, $type = null, $data = [])
	{
		if (!$type) {
			$type = Notifications::TYPE_NOTIFICATION;
		}

		return Notifications::message($this->primaryKey, $message, $type, $data);
	}

	/**
	 * get all users notifications
	 * @return ActiveDataProvider
	 */
	function getNotifications()
	{
		$notifications = Notifications::find()
			->where('user_id=:uid AND type=:type', [
				'uid'  => $this->id,
				'type' => Notifications::TYPE_NOTIFICATION,
			])
			->orderBy(['date_created' => SORT_DESC, 'status' => SORT_ASC]);

		return new ActiveDataProvider(['query' => $notifications]);
	}

	/**
	 * count users new notifications
	 * @return integer
	 */
	function countNewNotifications()
	{
		$notifications = Notifications::find()
			->where('user_id=:uid AND type=:type AND status=:status', [
				'uid'    => $this->id,
				'type'   => Notifications::TYPE_NOTIFICATION,
				'status' => Notifications::STATUS_NEW,
			]);

		return $notifications->count();
	}

	/**
	 * get users active ads
	 * @return ActiveDataProvider
	 */
	public function getMyActiveAds()
	{
		$query = $this->getAds();
		/* @var $query yii\db\ActiveQuery */
		return new ActiveDataProvider([
			'query' => $query->andWhere('status=:s', ['s' => Ads::STATUS_ACTIVE]),
		]);
	}

	/**
	 * get users profile url
	 */
	public function getProfileUrl()
	{
		return Yii::$app->urlManager->createAbsoluteUrl(['/user/profile/' . $this->id]);
	}

    public function checkUser(){
        $user = self::findOne(Yii::$app->user->id);
        if(empty($user->first_name)){ return true; }
        if(empty($user->last_name)){ return true; }
        if(empty($user->middle_name)){ return true; }
        if(empty($user->date_of_birth)){ return true; }
        //if(empty($user->phone)){ return true; }

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

}
