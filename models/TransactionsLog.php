<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ar_transactions_log".
 *
 * @property int $id
 * @property string $title
 * @property double $size
 * @property string $date_pay
 * @property int $contract_id
 * @property int $user_id
 * @property int $type
 * @property string $comment
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class TransactionsLog extends \yii\db\ActiveRecord
{
    const TYPE_RASXOD = 1;//Расход
    const TYPE_ZACH = 2;//Зачисления
    const STATUS_NEW = 1;
    const STATUS_REQUEST = 2;
    const STATUS_ACCEPT = 3;

    public static function getStatusLabels($status = false)
    {
        $ar = [
            self::STATUS_NEW   => 'Новый',
            self::STATUS_REQUEST => 'Запрос',
            self::STATUS_ACCEPT => 'Успешно',
        ];

        return $status !== false ? $ar[$status] : $ar;
    }
    public static function getTypeLabels($type = false)
    {
        $ar = [
            self::TYPE_RASXOD   => 'Расходы',
            self::TYPE_ZACH => 'Зачисления', 
        ];

        return $type !== false ? $ar[$type] : $ar;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ] + parent::behaviors();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transactions_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size','date_pay','title'], 'required'],
            [['size'], 'number'],
            [['comment', 'created_at', 'updated_at'], 'safe'],
            [['contract_id', 'user_id', 'type', 'status'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назначение платежа',
            'size' => 'Размер платежа',
            'date_pay' => 'Дата оплаты',
            'contract_id' => 'Договор',
            'user_id' => 'Пользователь',
            'type' => 'Тип перевода',
            'comment' => 'Комментарии',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
    /*public function beforeSave($insert)
    {
        $this->date_pay = date('Y-m-d',strtotime($this->date_pay));
        parent::beforeSave($insert);
    }*/
}
