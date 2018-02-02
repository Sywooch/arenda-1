<?php

namespace app\models\forms;

use app\models\Ads;
use app\models\Applications;
use yii;
use yii\base\Model as BaseModel;
use app\components\helpers\CommonHelper;
use app\models\User;

/**
 * InviteLessorForm
 */
class InviteCustomerForm extends BaseModel
{

	public $fio;
	public $email;
	public $objectId;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// fio, email, subject and body are required
			[['fio', 'email', 'objectId'], 'required'],
			// email has to be a valid email address
			['email', 'email'],
		];
	}

	/**
	 * @return array customized attribute labels
	 */
	public function attributeLabels()
	{
		return [
			'fio'      => 'ФИО',
			'email'    => 'E-mail',
			'objectId' => 'Объект',
		];
	}

	/**
	 * Sends an email to the specified email address using the information collected by this model.
	 * @param  array $viewParams array with variables sent in email view
	 * @return boolean whether the model passes validation
	 */
	public function send($params = [])
	{
		if ($this->validate()) {
			$ad = Ads::findOne(['id' => $this->objectId]);

			$renter = User::findOne(['email' => $this->email]);

			if ($renter != null) {
				// Если юзер зареган на сайте - ложим ему ещё и заявку
				$application = new Applications();
				$application->setAttributes([
					'ad_id'   => $ad->id,
					'user_id' => $renter->id,
					'status'  => Applications::STATUS_NEW,
				]);
				$application->save();
			}

			Yii::$app->mailer->compose('invite-customer', array_merge(['model' => $this, 'ad' => $ad], $params))->setFrom(CommonHelper::data()->getParam('supportEmail'))
				->setTo($this->email)
				->setSubject('Приглашение в ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
				->send();

			return true;
		} else {
			return false;
		}
	}

}
