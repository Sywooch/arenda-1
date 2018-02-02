<?php

namespace app\models;

use app\components\helpers\CommonHelper;
use yii\behaviors\TimestampBehavior;
use yii;

class ScreeningRequest extends \app\components\extend\ActiveRecord
{
	const TYPE_CREDIT = 1;
	const TYPE_BIO = 2;
	const TYPE_FULL = 3;
	
	const SCENARIO_SEND = 'send';
	
	const STATUS_PENDING = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_VALID = 3;
	const STATUS_INVALID = 4;
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%screening_request}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name_first', 'name_last', 'email'], 'required'],
			[['name_first', 'name_last', 'email'], 'string', 'max' => 100],
			[['email'], 'email'],
			[['email'], 'validateEmail'],
		];
	}

	public function validateEmail($attribute, $params)
	{
		$user = ScreeningRequest::find()->where(['email'=>$this->email,'user_id'=>Yii::$app->user->id])->one();
		if ($user) {
			$this->addError($attribute, 'У Вас уже есть запрос на проверку для этого E-mail');
		}
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_DEFAULT => ['name_first', 'name_last', 'email'],
			self::SCENARIO_SEND => ['name_first', 'name_last', 'email'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'request_date',
				'updatedAtAttribute' => false,
			],
		] + parent::behaviors();
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'name_first' => 'Имя',
			'name_last' => 'Фамилия',
			'email' => 'Email',
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
	 * @return \yii\db\ActiveQuery
	 */
	public function getReporter()
	{
		return $this->hasOne(User::className(), ['id' => 'reporter_id']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreditReport()
	{
		return $this->hasOne(ScreeningReport::className(), ['id' => 'report_credit_id']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBioReport()
	{
		return $this->hasOne(ScreeningReport::className(), ['id' => 'report_bio_id']);
	}
	
	public function getStatus()
	{
		if ($this->type == self::TYPE_FULL) {
			$bio_report = $this->bioReport;
			$credit_report = $this->creditReport;
			if ($bio_report && $credit_report) {
				if ($bio_report->status == ScreeningReport::STATUS_VALID && $credit_report->status == ScreeningReport::STATUS_VALID) {
					return self::STATUS_VALID;
				} elseif ($bio_report->status == ScreeningReport::STATUS_INVALID || $credit_report->status == ScreeningReport::STATUS_INVALID) {
					return self::STATUS_INVALID;
				} else {
					return self::STATUS_PROCESSING;
				}
			} elseif ($bio_report || $credit_report) {
				return self::STATUS_PROCESSING;
			} else {
				return self::STATUS_PENDING;
			}
		} elseif ($this->type == self::TYPE_CREDIT) {
			$report = $this->creditReport;
			if ($report) {
				if ($report->status == ScreeningReport::STATUS_VALID) {
					return self::STATUS_VALID;
				} elseif ($report->status == ScreeningReport::STATUS_INVALID) {
					return self::STATUS_INVALID;
				} else {
					return self::STATUS_PROCESSING;
				}
			} else {
				return self::STATUS_PENDING;
			}
		} else {
			$report = $this->bioReport;
			if ($report) {
				if ($report->status == ScreeningReport::STATUS_VALID) {
					return self::STATUS_VALID;
				} elseif ($report->status == ScreeningReport::STATUS_INVALID) {
					return self::STATUS_INVALID;
				} else {
					return self::STATUS_PROCESSING;
				}
			} else {
				return self::STATUS_PENDING;
			}
		}
	}
	
	public function sendRequest($type)
	{
		$request = new static();
		$request->setScenario(self::SCENARIO_SEND);
		$request->attributes = $this->attributes;
		$request->type = $type;
		$request->user_id = yii::$app->user->id;
		$request->save(false);
	}
	
	public function getTypeNames()
	{
		$types = [];
		if ($this->type == self::TYPE_CREDIT || $this->type == self::TYPE_FULL) {
			$types[] = 'Проверка кредитной истории';
		}
		if ($this->type == self::TYPE_BIO || $this->type == self::TYPE_FULL) {
			$types[] = 'Проверка личных данных';
		}
		return $types;
	}
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$user = User::find()->where(['email' => $this->email])->one();
				if ($user) {
					$this->reporter_id = $user->id;
					$need_report = false;
					if ($this->type == self::TYPE_BIO || $this->type == self::TYPE_FULL) {
						$report = ScreeningReport::find()->where([
							'user_id' => $user->id,
							'type' => ScreeningReport::TYPE_BIO,
						])->one();
						if ($report) {
							$this->report_bio_id = $report->id;
						} else {
							$need_report = true;
						}
					}
					if ($this->type == self::TYPE_CREDIT || $this->type == self::TYPE_FULL) {
						$report = ScreeningReport::find()->where([
							'user_id' => $user->id,
							'type' => ScreeningReport::TYPE_CREDIT,
						])->one();
						if ($report) {
							$this->report_credit_id = $report->id;
						} else {
							$need_report = true;
						}
					}
					if ($need_report) {
						yii::$app->mailer->compose('screening-request', [
							'request' => $this,
						])->setFrom(CommonHelper::data()->getParam('supportEmail'))
							->setTo($user->email)
							->setSubject('Вас просят пройти проверку данных на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
							->send();
					}
				} else {
					yii::$app->mailer->compose('sign-up-screening-request', [
							'request' => $this,
					])->setFrom(CommonHelper::data()->getParam('supportEmail'))
						->setTo($this->email)
						->setSubject('Вас просят пройти проверку данных на ' . CommonHelper::data()->getParam('tld', 'arenda.ru'))
						->send();
				}
			}
			return true;
		} else {
			return false;
		}
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
            't.reporter_id' => Yii::$app->user->id,
            't.is_new'     => 1,
        ]);

        return $query->count('t.id');
    }
}