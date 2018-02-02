<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * Password change form
 */
class PasswordChangeForm extends Model
{
	public $password;
	public $password_repeat;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['password', 'password_repeat'], 'trim'],
			['password', 'required'],
			['password', 'string', 'min' => 6],
			['password', 'validatePassword'],
			['password_repeat', 'validatePasswordRepeat', 'skipOnEmpty' => false, 'when' => function ($model) {
				return !$this->hasErrors('password');
			}],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'password'        => 'Новый Пароль',
			'password_repeat' => 'Повтор Нового пароля',
		];
	}


	public function validatePassword($attribute)
	{
		$user = Yii::$app->user->identity;

		if ($this->{$attribute} == $user->email) {
			$this->addError($attribute, 'Пароль не может совпадать с логином');
		}
	}

	public function validatePasswordRepeat($attribute)
	{
		if ($this->{$attribute} != $this->password) {
			$this->addError($attribute, 'Пароли не совпадают');
		}
	}

}