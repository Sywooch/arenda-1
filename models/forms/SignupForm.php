<?php

namespace app\models\forms;

use app\models\User;
use yii\base\Exception;
use yii\base\Model;
use app\components\helpers\CommonHelper;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{

	public $first_name;
	public $last_name;
	public $username;
	public $email;
	public $role = User::ROLE_LESSOR;// 
	public $phone;
	public $code;
	public $code_repeat;
	public $confirmed;

	public $password;
	public $password_repeat;

	/**
	 * get available roles while user registration
	 * @param string $role
	 * @return type
	 */
	public function getRoleLabels($role = null)
	{
		$ar = [
			User::ROLE_LESSOR   => 'Арендодатель',
			User::ROLE_CUSTOMER => 'Арендующий',
		];
		return $role ? $ar[$role] : $ar;
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'first_name', 'last_name'], 'filter', 'filter' => 'trim'],
			['first_name', 'validateName'],
			[['first_name', 'phone'], 'required'],
			['phone', 'validatePhone', 'skipOnEmpty' => false],
			['role', 'required'],
			['role', 'checkRole'],
			['username', 'unique', 'targetClass' => 'app\models\User'],
			[['username', 'first_name'], 'string', 'min' => 2, 'max' => 255],
			['email', 'filter', 'filter' => 'trim'],
			['email', 'filter', 'filter' => 'strtolower'],
			['email', 'required'],
			['email', 'email'],
			['email', 'checkUnique'],
			//['email', 'unique', 'targetClass' => 'app\models\User'],
			['code', 'required', 'message' => 'Неверный код'],
			['code', 'compare', 'compareValue' => Yii::$app->session->get(User::SESSION_SMS_SIGNUP_KEY), 'skipOnEmpty' => false, 'message' => 'Неверный код'],
			['confirmed', 'boolean'],
			['confirmed', 'required', 'requiredValue' => 1, 'message' => 'Вы должны подтвердить что вы согласны с Условиями пользования сайтом'],
			['password', 'required'],
			['password', 'string', 'min' => 6, 'max' => 16],
			['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => Yii::t('app', 'Пароли не совпадают')],
		];
	}

	public function validatePhone($attribute, $params) {
	    return true;
		if ($this->code == '' || $this->code == null) {
			$this->addError($attribute, 'Нужно подтвердить телефон');
		}
	}

	public function validateName($attribute, $params)
	{
		if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
			$this->addError($attribute, 'ФИО может содержать только русские буквы');
		}
	}
	public function checkUnique($attribute, $params)
	{
		$user = User::find()->where(['email'=>$this->$attribute])->one();
		if($user){
			if($user->status==User::STATUS_DELETED){
				$this->addError($attribute, '<p class="help-block help-block-error">Аккаунт '.$this->$attribute.' был удален. Используйте другие данные для регистрации.</p>');//Значение «'.$this->$attribute.'» удален. Вы можете <a href="#!" style="display:inline; color:#000;" class="shomodals" data-email="'.$this->$attribute.'" onclick="showmodal();">восстановить</a> этоть аккаунт.
			}else{
				$this->addError($attribute, '<p class="help-block help-block-error">Значение «'.$this->$attribute.'» для «'.$attribute.'» уже занято.</p>');
			}
		}
	}

	/**
	 * check if role is allowed
	 * @param type $attribute
	 * @param type $param
	 */
	public function checkRole($attribute, $params)
	{
		if (!array_key_exists($this->role, $this->getRoleLabels())) {
			$this->addError($attribute, Yii::t('yii', '{attribute} '.$this->role.User::ROLE_LESSOR.User::ROLE_CUSTOMER.' введено неправильно.', ['attribute' => $this->getAttributeLabel($attribute)]));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'              => 'id',
            'first_name'      => 'ФИО',
			'username'        => 'Логин',
			'email'           => 'Email',
			'role'            => 'Роль',
			'code'            => 'Введите код',
			'confirmed'       => 'Введите код',
			'password'        => 'Пароль',
			'password_repeat' => 'Повтор пароля',
            'last_name'            => 'Фамилия',
            'middle_name'          => 'Отчество',
            'status'               => 'Статус',
            'date_of_birth'        => 'Дата рождения',
            'phone'                => 'Телефон',
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if ($this->validate()) {
			$user = new User();
			$splitFio = explode(' ',$this->first_name);
			if (count($splitFio)==2)
			{
				$user->first_name = $splitFio[1];
				$user->last_name = $splitFio[0];
			}
			elseif (count($splitFio)==3)
			{
				$user->first_name = $splitFio[1];
				$user->last_name = $splitFio[0];
				$user->middle_name = $splitFio[2];
			}else{
				$user->first_name = $this->first_name;
				$user->last_name = '';
			}
			
			$user->username = $this->username;
			$user->email = $this->email;
			$user->phone = $this->phone;

			$user->password = $this->password;

			if ($user->save()) {
				Yii::$app->session->remove(User::SESSION_SMS_SIGNUP_KEY);

				$user->assignRole($this->role, $this->getRoleLabels());

				Yii::$app->mailer->compose('sign-up', [
					'user'     => $user,
				])->setFrom(CommonHelper::data()->getParam('supportEmail'))
					->setTo($this->email)
					->setSubject('Вы зарегистрировались на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
					->send();

				return $user;
			} else {
				throw new Exception('Ошибка регистрации');
			}
		}

		return null;
	}

}
