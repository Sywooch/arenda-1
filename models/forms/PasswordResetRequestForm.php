<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use yii\db\ActiveRecord as Model;
use app\components\helpers\CommonHelper;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'Неправильный Email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                //'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Такого Email нет в базе',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'email',
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail($resetLink)
    {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }
            if ($user->save()) {
                return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user, 'subject' => 'password reset', 'resetLink' => $resetLink])
                        ->setFrom(CommonHelper::data()->getParam('supportEmail'))
                        ->setTo($this->email)
                        ->setSubject('password reset')
                        ->send();
            }
        }

        return false;
    }

}