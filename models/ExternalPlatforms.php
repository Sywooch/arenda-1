<?php

namespace app\models;

use yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%external_platforms}}".
 *
 * @property integer $id
 * @property string $service_id
 * @property string $title
 * @property string $feed_template
 * @property string $params
 * @property integer $status
 *
 * @property ExternalPlatformFeeds[] $externalPlatformFeeds
 */
class ExternalPlatforms extends \yii\db\ActiveRecord
{

    const SERVICE_YANDEX = 'yandex';
    const SERVICE_CIAN = 'cian';
    const SERVICE_AVITO = 'avito';
    const SERVICE_IRR = 'irr';
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const PARAMS_PRICE = 'params[price]';

    /**
     * 
     * @param string $service
     * @return mixed
     */
    public function getDefaultServiceLabels($service = null)
    {
        $ar = [
            self::SERVICE_YANDEX => 'Яндекс',
            self::SERVICE_CIAN => 'ЦИАН',
            self::SERVICE_AVITO => 'AVITO',
            self::SERVICE_IRR => 'Из рук в руки',
        ];
        return $service ? $ar[$service] : $ar;
    }

    /**
     * 
     * @param integer $status
     * @return mixed
     */
    public function getStatusLabels($status = null)
    {
        $ar = [
            self::STATUS_DISABLED => 'Не активно',
            self::STATUS_ACTIVE => 'Активно',
        ];
        return $status !== null ? $ar[$status] : $ar;
    }

    /**
     * default templates
     * @param type $service
     * @return type
     */
    public function getDefaultTemplates($service)
    {
        $ar = [
            self::SERVICE_YANDEX => file_get_contents(__DIR__ . '/platforms-xml-templates/' . self::SERVICE_YANDEX . '.xhtml'),
            self::SERVICE_CIAN => null,
            self::SERVICE_AVITO => null,
            self::SERVICE_IRR => null,
        ];
        return $service ? $ar[$service] : $ar;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%external_platforms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['feed_template'], 'string'],
                [['status'], 'integer'],
                [['service_id'], 'string', 'max' => 100],
                [['title'], 'string', 'max' => 250],
                [['params'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'service_id' => 'Идентификатор сервиса',
            'title' => 'Название',
            'feed_template' => 'Шаблон фида',
            'params' => 'Параметры',
            'status' => 'Статус',
            self::PARAMS_PRICE => 'Цена'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExternalPlatformFeeds()
    {
        return $this->hasMany(ExternalPlatformFeeds::className(), ['platform_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);
        $this->params = Json::encode($this->params);
        return $bs;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $af = parent::afterFind();
        $this->params = Json::decode($this->params);
        return $af;
    }

    /**
     * 
     * @param type $const
     */
    public function getParam($const)
    {
        $c = str_replace('[', '.', $const);
        $c = str_replace('].', '.', $c);
        $c = str_replace(']', '', $c);
        return ArrayHelper::getValue($this, $c);
    }

    public function getPrice()
    {
        return yii::$app->formatter->asCurrency($this->getParam(self::PARAMS_PRICE), yii::$app->params['currency']);
    }

}
