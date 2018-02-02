<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class EstateUserForm extends Model
{

	public $first_name;
	public $last_name;
	public $middle_name;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
            [['first_name', 'last_name', 'middle_name'], 'filter', 'filter' => 'trim'],
            [['first_name', 'last_name', 'middle_name'], 'validateName'],
			[['first_name', 'last_name', 'middle_name'], 'required'],
		];
	}

    public function validateName($attribute, $params)
    {
        if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
            $this->addError($attribute, $this->$attribute.' может содержать только русские буквы');
        }
    }
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'first_name'     => 'Имя',
			'last_name'      => 'Фамиля',
			'middle_name'    => 'Отичество',
		];
	}


}
