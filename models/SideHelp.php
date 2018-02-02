<?php

namespace app\models;

use yii;
use app\models\Files;
use app\components\extend\ActiveRecord;

/**
 * This is the model class for table "{{%SideHelp}}".
 *
 * @property integer $id
 * @property string $image
 * @property string $title
 * @property string $content
 * @property string $url
 * @property integer $status
 */
class SideHelp extends ActiveRecord
{
	const STATUS_DISABLED = 0;
	const STATUS_ACTIVE = 1;

	/**
	 * init
	 * @return type
	 */
	public function init()
	{
		$init = parent::init();
		if ($this->isNewRecord) {
			$this->status = self::STATUS_ACTIVE;
		}
		return $init;
	}

	/**
	 * @param integer /boolean $status
	 */
	public function getStatusLabels($status = false)
	{
		$ar = [
			self::STATUS_ACTIVE   => 'Активно',
			self::STATUS_DISABLED => 'Не активно',
		];
		return $status !== false ? $ar[$status] : $ar;
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [] + parent::behaviors();
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%side_help}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['content', 'url'], 'string'],
			[['status'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'      => 'id',
			'content' => 'Содержание',
			'url'     => 'Ссылка',
			'status'  => 'Статус',
		];
	}

}
