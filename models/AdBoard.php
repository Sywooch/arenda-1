<?php

namespace app\models;


use app\components\helpers\CommonHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;
use yii;
use yii\helpers\Url;
use Handlebars\Handlebars;

/**
 * Class AdBoard
 * @package app\models
 *
 * @property string $prices
 * @property integer $id
 */

class AdBoard extends \app\components\extend\ActiveRecord
{
	const VALIDATION_OPTIONAL = 0;
	const VALIDATION_REQUIRED = 1;
	const VALIDATION_DICT_CIAN = 2;
	const VALIDATION_DICT_AVITO = 3;
	
	const STD_PRICE = 'standard';
	
	protected static $engine;
	
	public static function tableName()
	{
		return '{{%ad_board}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['code', 'name', 'prices', 'header_template', 'item_template', 'footer_template', 'validation'], 'required'],
			[['code', 'name'], 'string', 'max' => 100],
			[['code'], 'unique'],
			[['code'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
			[['enabled'], 'boolean'],
			[['prices'], 'validatePrices'],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'code' => 'Код',
            'name' => 'Название',
            'prices' => 'Ценовые условия',
            'description' => 'Описание',
            'header_template' => 'Шаблон шапки файла выгрузки',
            'item_template' => 'Шаблон объявления в файле выгрузки',
            'footer_template' => 'Шаблон подвала файла выгрузки',
            'enabled' => 'Активно',
            'validation' => 'Правила валидации',
		];
	}
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			$this->feed_updated = 0;
			$this->prices = Json::encode(is_array($this->prices) ? array_values($this->prices) : []);
			$this->validation = Json::encode(is_array($this->validation) ? $this->validation : []);
			return true;
		}
		return false;
	}

	public function afterFind()
	{
		$this->prices = empty($this->prices) ? [] : Json::decode($this->prices);
		$this->validation = empty($this->validation) ? [] : Json::decode($this->validation);
		parent::afterFind();
	}
	
	public function validatePrices()
	{
		if (!empty($this->prices) && is_array($this->prices)) {
			$codes = [];
			foreach ($this->prices as $price) {
				if ('' === trim($price['label']) || '' === trim($price['code']) || '' === trim($price['price'])) {
					$this->addError('prices', 'Заполните все данные в ценовых условиях');
					break;
				} elseif (!is_numeric($price['price'])) {
					$this->addError('prices', 'Цена должна быть числом');
					break;
				}
				if (in_array($price['code'], $codes)) {
					$this->addError('prices', 'Коды должны различаться');
					break;
				}
				$codes[] = $price['code'];
			}
		}
	}
	
	public function getStandardPrice()
	{
		if (!empty($this->prices) && is_array($this->prices)) {
			$count = count($this->prices);
			$min = -1;
			foreach ($this->prices as $price) {
				if ($count == 1 || $price['code'] == self::STD_PRICE) {
					return $price['price'];
				}
				if ($min == -1) {
					$min = $price['price'];
				} else {
					$min = min($min, $price['price']);
				}
			}
			return $min;
		}
		return 0;
	}
	
	public function getUrl()
	{
		return Url::to(sprintf('/adboards/export/%s.xml', $this->code), true);
	}
	
	public static function getAvailable()
	{
		$result = [];
		foreach (self::findAll(['enabled' => 1]) as $board) {
			$result[$board->id] = [
				'id' => $board->id,
				'code' => $board->code,
				'name' => $board->name,
				'prices' => $board->prices,
				'std_price' => $board->getStandardPrice(),
			];
		}
		return $result;
	}
	
	protected static function getEngine()
	{
		if (self::$engine === null) {
			self::$engine = new Handlebars();
			self::$engine->registerHelper('tr', function($value, $args) {
				return strtr($value, $args['hash']);
			});
			self::$engine->registerHelper('if_eq', function($a, $b, $args) {
				return "$a" == "$b" ? $args['fn']() : $args['inverse']();
			});
			self::$engine->registerHelper('md5file', function($value, $args) {
				$path = yii::getAlias('@app/web') . parse_url($value, PHP_URL_PATH);
				return is_file($path) ? md5_file($path) : '00000000000000000000000000000000';
			});
		}
		return self::$engine;
	}
	
	public function renderFeedHeader()
	{
		return static::getEngine()->render($this->header_template, [
			'date' => date('c'),
		]);
	}
	
	public function renderFeedElement($emement)
	{
		return static::getEngine()->render($this->item_template, $emement);
	}
	
	public function renderFeedFooter()
	{
		return static::getEngine()->render($this->footer_template, [
			'date' => date('c'),
		]);
	}
	
	public function rebuildRequired()
	{
		return static::makeAdsQuery()->where(['>', 'date_updated', $this->feed_updated])->count() > 0;
	}
	
	public function eachAdvert()
	{
		return static::makeAdsQuery()->each();
	}
	
	protected function makeAdsQuery()
	{
		return Ads::find()
			->joinWith(['publications'], true, 'INNER JOIN')
			->where(['board_id' => $this->id]);
	}
}