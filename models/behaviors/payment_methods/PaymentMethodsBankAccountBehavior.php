<?php
/**
 * Description of PaymentMethodsBankAccountBehavior
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
class PaymentMethodsBankAccountBehavior extends \yii\base\Behavior
{
	const FIO = 'fio';
	const BIK = 'bik';
	const ACCOUNT_NUMBER = 'account_number';
	const BANK_NAME = 'bank_name';

	/**
	 * constants labels
	 * @param type $constant
	 * @return type
	 */
	public function getBankAccountConstantLabels($constant = null)
	{
		$ar = [
			self::FIO            => 'ФИО',
			self::BIK            => 'БИК',
			self::ACCOUNT_NUMBER => '№ Р/с',
			self::BANK_NAME      => 'Название банка',
		];
		return $constant ? $ar[$constant] : $ar;
	}

	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return [
			BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
			BaseActiveRecord::EVENT_BEFORE_INSERT   => 'beforeSave',
			BaseActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeSave',
			BaseActiveRecord::EVENT_AFTER_DELETE    => 'afterDelete',
			BaseActiveRecord::EVENT_AFTER_FIND      => 'afterFind',
			BaseActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
			BaseActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',
		];
	}

	public function beforeValidate()
	{

	}

	public function beforeSave()
	{
		if ($this->owner->type == PaymentMethods::TYPE_BANK_ACCOUNT) {
			$ctx = stream_context_create([
					'http' => [
						'timeout' => 2,
					],
				]
			);

			$bik = $this->owner->data[self::BIK];

			$bankInfo = @file_get_contents("http://www.bik-info.ru/api.html?type=json&bik=" . $bik, 0, $ctx);

			$bankName = '';
			if ($bankInfo !== false) {
				$bank = @json_decode($bankInfo, true);

				if (is_array($bank) && isset($bank['name'])) {
					$bankName = $bank['name'];
				}
			}

			$data = $this->owner->data;
			$data[self::BANK_NAME] = $bankName;
			$this->owner->data = $data;
		}

		return true;
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

	public function getAccountNumber()
	{
		return @$this->owner->data[self::ACCOUNT_NUMBER];
	}

	public function getBankName()
	{
		return @$this->owner->data[self::BANK_NAME];
	}
}