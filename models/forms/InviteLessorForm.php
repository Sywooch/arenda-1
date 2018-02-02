<?php

namespace app\models\forms;

use yii;
use yii\base\Model as BaseModel;
use app\components\helpers\CommonHelper;
use app\models\User;

/**
 * InviteLessorForm 
 */
class InviteLessorForm extends BaseModel
{

    public $fio;
    public $email;

    public function getSubjects()
    {
        return [
            'Договор об аренде 1' => 'Договор об аренде 1',
            'Договор об аренде 2' => 'Договор об аренде 2',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // fio, email, subject and body are required
            [['fio', 'email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'email' => 'E-mail',
            'subject' => 'Тема',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  array  $viewParams array with variables sent in email view
     * @return boolean whether the model passes validation
     */
    public function send($params = [])
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose('invite-lessor', array_merge(['model' => $this], $params))->setFrom(CommonHelper::data()->getParam('supportEmail'))
                ->setTo($this->email)
                ->setSubject('Приглашение в '.CommonHelper::data()->getParam('tld','arenda.ru'))
                ->send();
            return true;
        } else {
            return false;
        }
    }

}
