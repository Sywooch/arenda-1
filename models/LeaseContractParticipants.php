<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%lease_contract_participants}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $lease_contract_id
 * @property integer $is_new
 *
 * @property LeaseContracts $leaseContract
 * @property User $user
 */
class LeaseContractParticipants extends \app\components\extend\ActiveRecord
{
	const STATUS_NOT_SIGNED = 0;
	const STATUS_SIGNED = 1;

	const SCENARIO_SIGN = 'sign';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%lease_contract_participants}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'lease_contract_id'], 'required'],
			[['user_id', 'lease_contract_id', 'signed','is_new'], 'integer'],
			['signed_fio', 'string', 'max' => 250],
			['signed_fio', 'trim'],

			[['signed_fio'], 'required', 'on' => self::SCENARIO_SIGN],
			['signed_fio', 'validateName'],

			['signed', 'boolean', 'on' => self::SCENARIO_SIGN],
			['signed', 'required', 'requiredValue' => 1, 'message' => 'Вы должны подтвердить что вы согласны с условиями договора', 'on' => self::SCENARIO_SIGN],
		];
	}

	public function validateName($attribute, $params)
	{
		if (!preg_match('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
			$this->addError($attribute, 'ФИО может содержать только латинские буквы');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'                => 'ID',
			'user_id'           => 'User ID',
			'lease_contract_id' => 'Lease Contract ID',
			'signed'            => 'Согласие',
			'signed_fio'        => 'ФИО',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getContract()
	{
		return $this->hasOne(LeaseContracts::className(), ['id' => 'lease_contract_id']);
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
	public function afterSave($insert, $changedAttributes)
	{
		$s = parent::afterSave($insert, $changedAttributes);
		/*if ($insert) {
			$message = 'Вы были добавлены как учасник к договору {contract_title}';
			$this->user->message($message, Notifications::TYPE_HISTORY, [
				'lease_contract_id' => $this->lease_contract_id,
				'contract_title'    => $this->contract->getTitle(),
			]);
		}*/
		return $s;
	}

	/**
	 * @inheritdoc
	 */
	public function afterDelete()
	{
		$ad = parent::afterDelete();
		/*$message = 'Вы были удалены как учасник с договора {contract_title}';
		$this->user->message($message, Notifications::TYPE_HISTORY, [
			'lease_contract_id' => $this->lease_contract_id,
			'contract_title'    => $this->contract->getTitle(),
		]);*/

		return $ad;
	}

	public function markViewed()
	{
		$this->is_new = 0;

		$this->save(false);
	}

	public static function getNewCount()
	{
		$query = self::find();
		$query->alias('t');
 
		$query->where([
			't.user_id' => Yii::$app->user->id,
			't.is_new'     => 1,
		]);

		return $query->count('t.id');
	}

}
