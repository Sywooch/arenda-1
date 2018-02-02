<?php

/**
 * @author postolachiserghei
 */

namespace app\models\behaviors\ads;

use yii;
use yii\db\BaseActiveRecord;
use app\components\helpers\CommonHelper;
use app\models\Ads;
use app\models\ExternalPlatforms;
use yii\helpers\Json;
use app\models\ExternalPlatformFeeds;

/**
 * This is the behavior for details management in \app\models\Ads".
 *
 * @property Ads $owner
 */
class IntegrationBehavior extends \yii\base\Behavior
{

    /**
     * @return self
     */
    public function getIntegration()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        $platforms = Json::decode($this->owner->place_add_to);
        if ($platforms && is_array($platforms)) {
            foreach ($platforms as $service => $value) {
                $model = $this->getPlatform($service, $value);
                ($value && $this->owner->status == Ads::STATUS_ACTIVE) ? $model->addFeed() : $model->deleteFeed();
            }
        }
    }

    /**
     * 
     * @param string $service
     * @param boolean $value
     * @return type
     */
    public function getPlatform($service)
    {
        if (method_exists($this, $service)) {
            return $this->{$service}();
        }
    }

    /**
     * 
     * @return integrations\IntegrateYandex
     */
    public function yandex()
    {
        $model = integrations\IntegrateYandex::find()->where([
                    'service_id' => ExternalPlatforms::SERVICE_YANDEX
                ])->one();
        $model->ad = $this->owner;
        return $model;
    }

    /**
     * generate offer XML
     * @param string $service
     * @return type
     */
    public function generateXML($service)
    {
        $model = $this->getPlatform($service);

        if (!$model) {
            return;
        }
        yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $items = '';
        $feeds = $model->getExternalPlatformFeeds()->where(['status' => ExternalPlatformFeeds::STATUS_APPROVED])->all();
        if (!$feed) {
            return null;
        }
        if ($feeds) {
            foreach ($feeds as $feed) {
                $items .= $feed->body;
            }
        }
        $xml = $model->getXmlBegin()
                . $items
                . $model->getXmlEnd();
        return $xml;
    }

}
