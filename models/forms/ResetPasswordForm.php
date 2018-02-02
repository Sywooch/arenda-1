<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
	public $password;
	public $password_repeat;

	/**
	 * @var \common\models\User
	 */
	private $_user;

	/**
	 * Creates a form model given a token.
	 *
	 * @param  string $token
	 * @param  array $config name-value pairs that will be used to initialize the object properties
	 * @throws \yii\base\InvalidParamException if token is empty or not valid
	 */
	public function __construct($token, $config = [])
	{
		if (empty($token) || !is_string($token)) {
			throw new InvalidParamException('Password reset token cannot be blank.');
		}
		$this->_user = User::findByPasswordResetToken($token);
		if (!$this->_user) {
			throw new InvalidParamException('Wrong password reset token.');
		}
		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['password', 'required'],
			['password', 'string', 'min' => 6],
			['password_repeat', 'string'],
			['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false,  'message' => 'Пароли не совпадают'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password'        => 'Новый пароль',
			'password_repeat' => 'Повтор пароля',
		];
	}

	/**
	 * Resets password.
	 *
	 * @return boolean if password was reset.
	 */
	public function resetPassword()
	{
		$user = $this->_user;
		$user->password = $this->password;
		$user->removePasswordResetToken();
		if($user->status==User::STATUS_DELETED){
			$user->status = User::STATUS_ACTIVE;
		}		
		$saved = $user->save();
		if ($saved) {
			Yii::$app->user->login($user);
		}
		return $saved;
	}

}