<?php

namespace app\models;

use yii;
use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%applications}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ad_id
 * @property string $data
 * @property integer $date_created
 * @property integer $status
 *
 * @property Ads $ad
 * @property User $user
 * @property ApplicationRoommates $roommates
 */
class Applications extends \app\components\extend\ActiveRecord
{

	const STATUS_NEW = 0;
	const STATUS_IN_ARCHIVE = 1;
	const STATUS_DELETED = 2;
	const STATUS_WAITING_CONFIRMATION = 3;
	const STATUS_WAITING_PARTICIPANTS = 4;
	const STATUS_DONE = 5;

	/**
	 * @param integer /boolean $status
	 * @return type
	 */
	public function getStatusLabels($status = false)
	{
		$ar = [
			self::STATUS_NEW                  => 'Отправлено',
			self::STATUS_IN_ARCHIVE           => 'В архиве',
			self::STATUS_DELETED              => 'Удялено',
			self::STATUS_WAITING_CONFIRMATION => 'Ожидание вашего подтверждения',
			self::STATUS_WAITING_PARTICIPANTS => 'Ожидание еще одного жильца',
			self::STATUS_DONE                 => 'Закончено',
		];
		return $status !== false ? $ar[(int)$status] : $ar;
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%applications}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			[
				'class'              => TimestampBehavior::className(),
				'createdAtAttribute' => 'date_created',
				'updatedAtAttribute' => null,
			],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'ad_id', 'date_created', 'status', 'is_new'], 'integer'],
			[['data'], 'safe'],
			[['comment'], 'string', 'max' => 255],
			[['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ad_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'           => 'ID',
			'user_id'      => 'Пользователь',
			'ad_id'        => 'объявление',
			'data'         => 'Доп. Данные',
			'date_created' => 'Создано',
			'status'       => 'Статус',
		];
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

		$adTableName = Ads::tableName();
		$estateTableName = RealEstate::tableName();

		$query->innerJoin(['ad' => $adTableName], 't.ad_id = ad.id');
		$query->innerJoin(['es' => $estateTableName], 'ad.real_estate_id = es.id');
		$query->where([
			'es.user_id' => Yii::$app->user->id,
			't.is_new'     => 1,
		]);

		return $query->count('t.id');
	}

	public static function getArchiveCount()
	{
		$query = self::find();
		$query->alias('t');

		$adTableName = Ads::tableName();
		$estateTableName = RealEstate::tableName();

		$query->innerJoin(['ad' => $adTableName], 't.ad_id = ad.id');
		$query->innerJoin(['es' => $estateTableName], 'ad.real_estate_id = es.id');

		$query->where([
			'es.user_id' => Yii::$app->user->id,
			't.status'     => self::STATUS_IN_ARCHIVE,
		]);

		return $query->count('t.id');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAd()
	{
		return $this->hasOne(Ads::className(), ['id' => 'ad_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRoommates()
	{
		return $this->hasMany(ApplicationRoommates::className(), ['application_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	public function beforeSave($insert)
	{
		$bs = parent::beforeSave($insert);
		$this->data = Json::encode($this->data);
		return $bs;
	}

	public function archive()
	{
		$this->status = self::STATUS_IN_ARCHIVE;
		$this->save();
	}

}
