<?php

namespace app\models\forms;

use Yii;
use yii\db\ActiveRecord;
use app\components\helper\Helper;
use app\components\helpers\CommonHelper;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends \yii\base\Model
{

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'verification code',
            'name' => 'Представьтесь',
            'email' => 'Почта',
            'subject' => 'subject',
            'body' => 'Сообщения',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($model)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose('contact', [
                'model' => $model
            ])
                ->setFrom(CommonHelper::data()->getParam('supportEmail'))
                ->setTo(CommonHelper::data()->getParam('infoEmail'))
                ->setSubject("Новое сообщение с   " . CommonHelper::data()->getParam('tld', 'arenda.ru'))
                ->send();
            return true;
        } else {
            return false;
        }
    }
}
