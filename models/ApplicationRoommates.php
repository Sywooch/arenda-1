<?php

namespace app\models;

use yii;
use app\components\helpers\CommonHelper;
use app\components\extend\Html;
use app\components\extend\Url;

/**
 * This is the model class for table "{{%applications_roommates}}".
 *
 * @property integer $id
 * @property integer $application_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * 
 * @property Applications $application
 */
class ApplicationRoommates extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%applications_roommates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['application_id', 'first_name', 'last_name', 'email'], 'required'],
                [['application_id'], 'integer'],
                [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
                [['email'], 'email'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Applications::className(), ['id' => 'application_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Заявка',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
        ];
    }

    /**
     * set application
     * @param integer $adId
     * @param integer $userId
     */
    function setApplication($adId, $userId)
    {
        $ad = Ads::find()->where(['id' => (int) $adId, 'status' => Ads::STATUS_ACTIVE])->one();
        if (!$ad) {
            yii::$app->controller->throwNoPageFound();
        }
        $application = Applications::find()->where(['user_id' => (int) $userId, 'ad_id' => $ad->primaryKey])->one();
        if (!$application) {
            $application = new Applications();
            $application->user_id = (int) $userId;
            $application->ad_id = (int) $adId;
            $application->status = Applications::STATUS_NEW;
            if ($application->validate()) {
                $application->save();
            }
        }
        if ($application) {
            $this->application_id = $application->primaryKey;
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $as = parent::afterSave($insert, $changedAttributes);
        if ($this->isNewRecord || ($this->oldAttributes['email'] != $this->email)) {
            $this->notificateRoommates();
        }
        return $as;
    }

    /**
     * @inheritdoc
     */
    function notificateRoommates()
    {
        if ($user = User::findByEmail($this->email)) {
            $body = CommonHelper::str()->replaceTagsWithDatatValues(Html::tag('h4', 'Здравствуйте {roommate-username}')
                    . 'Вы были добавлены как сожитель пользователем "{username}"', [
                'roommate-username' => $user->fullName,
                'username' => $this->application->user->fullName,
                'project-link' => Html::a(yii::$app->name, 'http://' . CommonHelper::data()->getParam('tld', 'arenda.ru'), ['target' => 'blank']),
            ]);
            $user->message($body)->save();
        } else {
            $body = CommonHelper::str()->replaceTagsWithDatatValues(Html::tag('h4', 'Здравствуйте {roommate-username}')
                    . 'Вы были добавлены как сожитель пользователем "{username}" в рамках проекта {project-link}<br/><br/> '
                    . 'Вам нужно зарегистрироваться чтобы вы могли принять приглашение о сожительстве.', [
                'roommate-username' => $this->first_name . ' ' . $this->last_name,
                'username' => $this->application->user->fullName,
                'project-link' => Html::a(yii::$app->name, 'http://' . CommonHelper::data()->getParam('tld', 'arenda.ru'), ['target' => 'blank']),
            ]);

            Yii::$app->mailer->compose()
                    ->setFrom('noreply@' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
                    ->setTo($this->email)
                    ->setSubject('Вы были добавлены как сожитель')
                    ->setHtmlBody($body)
                    ->send();
        }
    }

    /**
     * get full name
     * @return string
     */
    function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
