<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "{{%pay_ad_items}}".
 *
 * @property int $id
 * @property int $payId Оплаты
 * @property int $adId Объявление
 * @property int $serviceId Сервис
 * @property int $statusId Статус
 * @property string $dateCreate Дата создания
 * @property string $dateProcess Дата обработки
 * @property double $sum Сумма
 *
 * @property Pay $pay
 */
class PayAdItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pay_ad_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payId', 'adId', 'serviceId', 'statusId'], 'default', 'value' => null],
            [['payId', 'adId', 'serviceId', 'statusId'], 'integer'],
            [['dateCreate', 'dateProcess'], 'safe'],
            [['sum'], 'number'],
            [['payId'], 'exist', 'skipOnError' => true, 'targetClass' => Pay::className(), 'targetAttribute' => ['payId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payId' => 'Оплаты',
            'adId' => 'Объявление',
            'serviceId' => 'Сервис',
            'statusId' => 'Статус',
            'dateCreate' => 'Дата создания',
            'dateProcess' => 'Дата обработки',
            'sum' => 'Сумма',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPay()
    {
        return $this->hasOne(Pay::className(), ['id' => 'payId']);
    }

    public function paid(){
        $this->dateProcess = new Expression('now()');
        $this->statusId = Pay::STATUS_PAY;
        return $this->save(false);
    }

    public function isPaid(){
        return $this->statusId == Pay::STATUS_PAY;
    }
}
