<?php

namespace app\models;

use yii;
use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;
use app\components\helpers\CommonHelper;
use app\components\extend\ActiveRecord;

/**
 * This is the model class for table "{{%notifications}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property string $data
 * @property integer $date_created
 * @property integer $type
 * @property integer $status
 *
 * @property User $user
 */
class Notifications extends ActiveRecord
{

    const STATUS_NEW = 1;
    const STATUS_VIEWED = 2;
    const TYPE_NOTIFICATION = 1;
    const TYPE_HISTORY = 2;

    /**
     * @param integer/boolean $status
     * @return type
     */
    public function getStatusLabels($status = false)
    {
        $ar = [
            self::STATUS_NEW => 'Новый',
            self::STATUS_VIEWED => 'Просмотрен',
        ];
        return $status !== false ? $ar[$status] : $ar;
    }

    /**
     * @param string/boolean $type
     * @return type
     */
    public function getInputTypesLabels($type = false)
    {
        $ar = [
            self::TYPE_HISTORY => 'История',
            self::TYPE_NOTIFICATION => 'Оповещение',
        ];
        return $type !== false ? $ar[$type] : $ar;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notifications}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
                [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
                'updatedAtAttribute' => null,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['user_id', 'type', 'status', 'date_created'], 'integer'],
                [['message'], 'string'],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'message' => 'Сообшение',
            'data' => 'Доп. Данные',
            'type' => 'Тип',
            'status' => 'Статус',
            'date_created' => 'Создано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * 
     * @param integer $userId
     * @param string $message
     * @param integer $type default Notifications::TYPE_NOTIFICATION
     * @param array $data
     * @return boolean
     */
    public static function message($userId, $message, $type = null, $data = [])
    {
        if (!$type || (int) $type == 0) {
            $type = self::TYPE_NOTIFICATION;
        }

        if (trim($message) != '') {
            $model = new Notifications();
            $model->user_id = (int) $userId;
            $model->message = (string) $message;
            $model->status = self::STATUS_NEW;
            $model->type = $type;
            $model->data($data);
        }

        return $model->save();
    }

    /**
     * 
     * @param type $param
     * @return $this
     */
    public function data($param = [])
    {
        $this->data = array_merge((array) $this->data, $param);
        return $this;
    }

    /**
     * notifications for all administrators users 
     * @param string $message
     * @param integer $type default Notifications::TYPE_NOTIFICATION
     * @param array $data
     */
    public static function messageAdmins($message, $type = null, $data = [])
    {
        $user = new User();
        foreach ($user->findByRole(User::ROLE_ADMIN)->andWhere(['status' => User::STATUS_ACTIVE])->all() as $adminUser) {
            self::message($adminUser->primaryKey, $message, $type, $data);
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);
        if ($this->isNewRecord) {
            $this->data = array_merge([
                'user' => yii::$app->user->isGuest ? 'guest: (0)' : yii::$app->user->identity->fullName . ': (' . yii::$app->user->id . ')',
                'user-ip' => yii::$app->request->userIP,
                'action' => yii::$app->controller->action->id,
                'controller' => yii::$app->controller->id,
                'module' => yii::$app->id,
                    ], (array) $this->data);
        }
        $this->message = CommonHelper::str()->replaceTagsWithDatatValues($this->message, $this->data);
        $this->data = Json::encode($this->data);
        return $bs;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $af = parent::afterFind();
        $this->data = Json::decode($this->data);
        return $af;
    }

    /**
     * mark notification as viewed
     */
    public function markAsViewed()
    {
        if (!$this->isNewRecord && $this->status === self::STATUS_NEW) {
            $this->status = self::STATUS_VIEWED;
            if ($this->validate()) {
                $this->save();
            }
        }
    }

}
