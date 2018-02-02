<?php
/**
 * Description of PaymentMethodsCardBehavior
 *
 * @author postolachiserghei
 */

namespace app\models\behaviors\payment_methods;

use yii;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;
use yii\gii\components\ActiveField;
use yii\helpers\ArrayHelper;
use app\models\PaymentMethods;

/**
 * This is the behavior for data "card" in \app\models\PaymentMethods".
 *
 * @property \app\models\PaymentMethods $owner
 */
class PaymentMethodsCardBehavior extends \yii\base\Behavior
{
    const CARD_NUMBER = 'number';
    const VALID_YEAR = 'valid_year';
    const VALID_MONTH = 'valid_month';
    const CVV_CVC = 'cvv_cvc';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const COUNTRY = 'country';
    const CITY = 'city';
    const CURRENT_ADDRESS = 'current_address';
    const ZIP_CODE = 'zip_code';
    const PHONE = 'phone';
    const EMAIL = 'email';

    /**
     * constants labels
     * @param type $constant
     * @return type
     */
    public function getCardConstantLabels($constant = null)
    {
        $ar = [
            self::CARD_NUMBER => 'Номер карты',
            self::VALID_YEAR => 'Срок действия (год)',
            self::VALID_MONTH => 'Срок действия (месяц)',
            self::CVV_CVC => 'CVV/CVC',
            self::COUNTRY => 'Страна',
            self::CITY => 'Город',
            self::FIRST_NAME => 'Имя',
            self::LAST_NAME => 'Фамилия',
            self::CURRENT_ADDRESS => 'Расчетный адрес',
            self::ZIP_CODE => 'Индекс',
            self::PHONE => 'Телефон',
            self::EMAIL => 'Эл. почта',
        ];
        return $constant ? $ar[$constant] : $ar;
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function beforeValidate()
    {
        $owner = $this->owner;
        if (!$owner->isNewRecord) {
            $attributes = [];
            foreach ($owner->data as $k => $v) {
                $oldValue = @Json::decode($owner->oldAttributes['data'])[$k];
                $attributes[$k] = ($oldValue == $v || trim($v) == '') ? $oldValue : $v;
            }
            $this->owner->data = $attributes;
        }
    }

    public function beforeSave()
    {
        
    }

    public function afterSave()
    {
        
    }

    public function afterDelete()
    {
        
    }

    public function afterFind()
    {
        
    }

    /**
     * get card number
     * @param boolean $encode
     * @return string
     */
    public function getCardNumber($encode = true)
    {
        return $encode ? substr_replace(@$this->owner->data[self::CARD_NUMBER], ' **** **** ', 4, 10) : @$this->owner->data[self::CARD_NUMBER];
    }

}