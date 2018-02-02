<?php

namespace app\models\forms;

use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class UserAddationalContactForm extends \yii\base\Model
{

    public $first_name;
    public $last_name; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // firstname, lastname are required
            [['first_name', 'last_name'], 'safe'],
            [['first_name'], 'validateName'],
            [['last_name'], 'validateLastName'],
            // email has to be a valid email address
        ];
    }
    public function validateLastName($attribute, $params)
    {
        if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
            $this->addError($attribute, 'Фамиля может содержать только русские буквы');
        }
    }
    public function validateName($attribute, $params)
    {
        if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
            $this->addError($attribute, 'Имя может содержать только русские буквы');
        }
        if(!empty($this->first_name) AND empty($this->last_name)){
            $this->addError('last_name', 'Необходимо заполнить «Фамиля».');
        }
    }
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамиля', 
        ];
    }
    
}
