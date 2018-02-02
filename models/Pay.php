<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%pay}}".
 *
 * @property int $id
 * @property double $sum Сумма
 * @property string $dateCreate Дата создания
 * @property string $dateProcessing Дата обработки
 * @property int $statusId Статус
 * @property int $objectId Объект оплаты
 * @property int $typeId Тип объекта(Объявление, перевод)
 * @property string $ip Ip адрес
 *
 * @property PayAdItems[] $adItems
 */
class Pay extends \yii\db\ActiveRecord
{
    public $serviceId = '';

    public $cardNumber;
    public $cardCode;

    const STATUS_NO = 1;
    const STATUS_PAY = 2;
    const STATUS_REJECT = 3;

    const TYPE_AD = 1;
    const TYPE_REMITTANCE = 2;

    public function description()
    {
        return 'Размещения объявления на торговых площадках №' . $this->id;
    }

    public function statusNo()
    {
        return $this->statusId == self::STATUS_NO;
    }

    public function statusPaid()
    {
        return $this->statusId == self::STATUS_PAY;
    }

    public function statusReject()
    {
        return $this->statusId == self::STATUS_REJECT;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pay}}';
    }

    const SC_PAY = 'pay';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'], 'number'],
            [['dateCreate', 'dateProcessing'], 'safe'],
            [['statusId', 'objectId', 'typeId'], 'default', 'value' => null],
            [['statusId', 'objectId', 'typeId'], 'integer'],
            [['ip'], 'string', 'max' => 32],

            ['serviceId', 'string', 'on' => self::SC_PAY],
            ['serviceId', 'required', 'on' => self::SC_PAY],
            ['cardNumber', 'string', 'min' => 16, 'max' => 16, 'on' => self::SC_PAY],
            ['cardCode', 'string', 'min' => 4, 'max' => 4, 'on' => self::SC_PAY],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'dateCreate' => 'Дата создания',
            'dateProcessing' => 'Дата обработки',
            'statusId' => 'Статус',
            'objectId' => 'Объект оплаты',
            'typeId' => 'Тип объекта(Объявление, перевод)',
            'ip' => 'Ip адрес',
        ];
    }

    public function getTypeFromObject($object)
    {
        switch ($object::className()) {
            case Ads::className():
                return self::TYPE_AD;
        }
    }

    public function create($object)
    {
        $this->typeId = $this->getTypeFromObject($object);
        $this->objectId = $object->id;
        $this->sum = 0;
        $this->dateCreate = new Expression('now()');
        $this->statusId = self::STATUS_NO;
        $this->ip = Yii::$app->request->userIP;
        $this->save();
    }

    public function calculate()
    {
        $serviceArr = strpos($this->serviceId, ',') ? explode(',', $this->serviceId) : [$this->serviceId];

        /** @var  $serviceItems AdBoard[] */
        $serviceItems = AdBoard::findAll(['id' => $serviceArr]);
        $sum = 0;

        PayAdItems::deleteAll(['payId' => $this->id, 'statusId' => Pay::STATUS_NO]);

        foreach ($serviceItems as $serviceItem) {

            $price = $serviceItem->prices[0]['price'];
            $serviceId = $serviceItem->id;

            $payItemObject = PayAdItems::findOne([
                'adId' => $this->objectId,
                'payId' => $this->id,
                'serviceId' => $serviceId
            ]);

            if (!$payItemObject) {
                $payItemObject = new PayAdItems();
                $payItemObject->dateCreate = new Expression('now()');
                $payItemObject->sum = $price;
                $payItemObject->payId = $this->id;
                $payItemObject->adId = $this->objectId;
                $payItemObject->serviceId = $serviceId;
                $payItemObject->statusId = Pay::STATUS_NO;
                $payItemObject->save();
            }

            $sum += $price;
        }

        $this->statusId = self::STATUS_NO;
        $this->sum = $sum;
        $this->save();
    }

    public function paid()
    {
        $sum = 0;

        foreach ($this->adItems as $adItem) {

            $adItem->paid();
            $sum += $adItem->sum;

            $adsPublication = AdPublication::findOne(['ad_id' => $this->objectId, 'board_id' => $adItem->serviceId]);
            if (!$adsPublication) {
                $adsPublication = new AdPublication();
                $adsPublication->ad_id = $this->objectId;
                $adsPublication->board_id = $adItem->serviceId;
                $adsPublication->price_code = AdBoard::STD_PRICE;
                $adsPublication->save(false);
            }
        }

        $this->sum = $sum;

        $servicesCount = AdBoard::find()->count();
        if ($servicesCount == sizeof($this->adItems)) {
            $this->statusId = self::STATUS_PAY;
        }

        $this->dateProcessing = new Expression('now()');

        return $this->save(false);
    }

    public function getAdItems()
    {
        return $this->hasMany(PayAdItems::className(), ['payId' => 'id']);
    }

    protected $checkPay = [];

    public function serviceIsPay($serviceId)
    {

        if ($this->checkPay) {
            if (!array_key_exists($serviceId, $this->checkPay)) {
                return false;
            }
            return $this->checkPay[$serviceId];
        }

        $items = $this->adItems;

        if (!$items) {
            return false;
        }

        foreach ($items as $item) {
            $this->checkPay[$item->serviceId] = $item->isPaid();
        }

        return $this->serviceIsPay($serviceId);
    }

    public function paidMessage(){
    	return 'Оплачено';
        return sprintf('Оплачено %s ₽',$this->sum);
    }
}
