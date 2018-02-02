<?php

namespace app\models\forms;

use Yii;
use yii\base\Model as BaseModel;
use app\models\Ads;

class AdApplicationSendForm extends BaseModel
{
	public $comment;
	public $ad_id;
	public $user_id;
	public $fake_field;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['comment'], 'string', 'max' => 255],
			[['ad_id', 'user_id'], 'required'],
			[['ad_id'], 'integer'],
			[['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
			['fake_field', 'validateAd', 'skipOnEmpty' => false],
		];
	}

	public function validateAd($attribute, $params) {
		$ad = Ads::findOne(['id' => $this->ad_id]);

		if ($ad == null) {
			$this->addError('fake_field', 'Объявление не найдено');
		} else {
			$estate = $ad->estate;

			if ($estate->user_id == $this->user_id) {
				$this->addError('fake_field', 'Вы не можете подать заявку на собственное объявление');
			}
		}
	}

	/**
	 * @return array customized attribute labels
	 */
	public function attributeLabels()
	{
		return [
			'comment' => 'Комментарий',
		];
	}

}
