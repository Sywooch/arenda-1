<?php

namespace app\models;

use app\components\validators\CreditCardValidator;
use yii;
use yii\helpers\Json;
use app\models\behaviors\payment_methods\PaymentMethodsCardBehavior;
use app\models\behaviors\payment_methods\PaymentMethodsBankAccountBehavior;

/**
 * This is the model class for table "{{%payment_methods}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $data
 * @property integer $type
 * @property integer $status
 *
 * @property LeaseContracts[] $leaseContracts
 * @property User $user
 */
class PaymentMethods extends \app\components\extend\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLED = 2;

	const TYPE_CARD = 1;
	const TYPE_BANK_ACCOUNT = 2;

	public $fake_attribute = null;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			[
				'class' => PaymentMethodsBankAccountBehavior::className(),
			],
			[
				'class' => PaymentMethodsCardBehavior::className(),
			],
		]);
	}

	/**
	 * @param integer /boolean $status
	 * @return type
	 */
	public function getStatusLabels($status = false)
	{
		$ar = [
			self::STATUS_ACTIVE   => 'Активен',
			self::STATUS_DISABLED => 'Не активен',
		];
		return $status !== false ? $ar[$status] : $ar;
	}

	/**
	 * @param integer /boolean $type
	 * @return type
	 */
	public function getTypeLabels($type = false)
	{
		$ar = [
			self::TYPE_CARD         => 'Кредитная карта',
			self::TYPE_BANK_ACCOUNT => 'Банковский счет',
		];
		return $type !== false ? $ar[$type] : $ar;
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%payment_methods}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'data', 'type', 'status'], 'required'],
			[['user_id', 'type', 'status'], 'integer'],
			[['link_id'], 'string'],
			[['fake_attribute'], 'validateData', 'skipOnEmpty' => false],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * validate inserted data
	 */
	public function validateData($attribute, $params)
	{
		if ($this->type == self::TYPE_CARD) {
			//$this->validateCardNumber('data', $params);
			//$this->validateCardDate('data', $params);
		} else if ($this->type == self::TYPE_BANK_ACCOUNT) {
			$this->validateBankAccount('data', $params);
		}
	}

	/**
	 * validate inserted card data
	 */
	public function validateCardNumber($attribute, $params)
	{
		$validator = new CreditCardValidator();

		$attrName = $attribute.'['.PaymentMethodsCardBehavior::CARD_NUMBER.']';
		$attrValue = $this->$attribute[PaymentMethodsCardBehavior::CARD_NUMBER];

		$attrValue = preg_replace('/[_ -]+/', '', $attrValue);

		if(!$validator->validate($attrValue, $error)) {
			$this->addError('fake_attribute', $error);
		}

	}

	public function validateCardDate($attribute, $params)
	{
		$validator = new CreditCardValidator();

		$attrMonthName = $attribute.'['.PaymentMethodsCardBehavior::VALID_MONTH.']';
		$attrMonthValue = $this->$attribute[PaymentMethodsCardBehavior::VALID_MONTH];

		$attrYearName = $attribute.'['.PaymentMethodsCardBehavior::VALID_YEAR.']';
		$attrYearValue = $this->$attribute[PaymentMethodsCardBehavior::VALID_YEAR];

		$attrMonthValue = preg_replace('/[_ -]+/', '', $attrMonthValue);
		$attrYearValue = preg_replace('/[_ -]+/', '', $attrYearValue);

		if(!$validator->validateDate($attrMonthValue, $attrYearValue)) {
			$this->addError('fake_attribute', 'Неправильный срок действия карты');
		}

	}

	/**
	 * validate inserted card data
	 */
	public function validateBankAccount($attribute, $params)
	{
		$attrName = 'data[' . PaymentMethodsBankAccountBehavior::FIO . ']';
		$attrValue = $this->data[PaymentMethodsBankAccountBehavior::FIO];

		if (!preg_match ('/^[\p{Cyrillic}\s]+$/u', $attrValue)) {
			$this->addError('fake_attribute', 'ФИО может содержать только русские буквы');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'      => 'ID',
			'user_id' => 'Пользователь',
			'data'    => 'Данные',
			'type'    => 'Тип',
			'status'  => 'Статус',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getLeaseContracts()
	{
		return $this->hasMany(LeaseContracts::className(), ['payment_method_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		$bs = parent::beforeSave($insert);
		$this->data = Json::encode($this->data);
		return $bs;
	}

	public function afterFind()
	{
		$af = parent::afterFind();
		$this->data = Json::decode($this->data);
		return $af;
	}

	public function getInfo()
	{
		if ($this->isNewRecord)
			return null;
		$tmp = '';
		$model = $this;
		/* @var $model PaymentMethodsBankAccountBehavior */
		/* @var $model PaymentMethodsCardBehavior */
		switch ($this->type) {
			case self::TYPE_BANK_ACCOUNT:
				$tmp = $model->getBankName();
				break;
			case self::TYPE_CARD:
				$tmp = $model->getCardNumber();
				break;
			default :
				$tmp = 'Н/А';
				break;
		}
		return '[' . $this->getTypeLabels($this->type) . '] - ' . $tmp;
	}

}