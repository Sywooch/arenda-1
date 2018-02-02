<?php

/**
 * @author postolachiserghei
 */

namespace app\models\behaviors\ads\integrations;

use yii;
use app\components\helpers\CommonHelper;
use app\components\extend\Url;
use app\models\Ads;
use app\models\ExternalPlatforms;
use app\models\ExternalPlatformFeeds;

/**
 * This is the yandex integration class.
 * @property Ads $ad
 */
class IntegrateYandex extends ExternalPlatforms
{

    public $ad;

    /**
     * see https://yandex.ru/support/webmaster/realty/requirements.xml#events
     * @param mixed $category default null (can be set integer from Ads::ACCOMMODATION_TYPE_{...} )
     * @return mixed
     */
    public function categories($category = null)
    {
        $ar = [
            Ads::ACCOMMODATION_TYPE_APARTMENT => 'квартира',
            Ads::ACCOMMODATION_TYPE_CONDOMINIUM => 'квартира',
            Ads::ACCOMMODATION_TYPE_DUPLEX => 'дом',
            Ads::ACCOMMODATION_TYPE_LOFT => 'дом',
            Ads::ACCOMMODATION_TYPE_HOUSE => 'дом',
        ];
        return $category ? $ar[$category] : $ar;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
                ['ad']
        ]);
    }

    public function getXmlBegin()
    {
        return '<?xml version="1.0" encoding="UTF-8"?> 
                    <realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06">
                        <generation-date>' . date(DATE_ATOM, date('U')) . '</generation-date>';
    }

    public function getXmlBody()
    {
        if (isset($_GET['attr'])) {
            $d = array_merge($this->ad->attributes, $this->ad->realEstate->attributes, $this->ad->realEstate->user->attributes, $this->ad->realEstate->user->info->attributes);
            echo '<pre>' . print_r($d, TRUE) . '</pre>';
            die();
        }

        $ad = $this->ad;
        $realEstate = $ad->realEstate;
        $user = $realEstate->user;
        $userInfo = $user->info;

        $initialData = array_merge($ad->attributes, $realEstate->attributes, $user->attributes, $userInfo->attributes);
        $data = array_merge($initialData, [
            'id' => $ad->primaryKey,
            'accommodation_type' => $this->categories($ad->accommodation_type),
            'url' => $ad->getUrl(true),
            'logo' => Url::to($userInfo->getFile('logo')->imageUrl, true),
            'currency' => yii::$app->params['currency'],
            'condition' => $ad->getConditionTypeLabels($ad->condition),
            'date_created' => date(DATE_ATOM, $ad->date_created),
            'date_updated' => date(DATE_ATOM, $ad->date_updated),
            'image' => Url::to($realEstate->getFile('cover_image')->imageUrl, true),
            'all_images' => $this->getImages($ad)
        ]);
        return CommonHelper::str()->replaceTagsWithDatatValues($this->feed_template, $data);
    }

    public function getXmlEnd()
    {
        return '</realty-feed>';
    }

    /**
     * formate datetime to yandex standarts
     * @param integer $date (unix time)
     * @return string
     */
    public function formatedDate($date)
    {
        return $date;
    }

    /**
     * generate image tags
     * @param Ads $ad
     */
    public function getImages($ad)
    {
        $tmp = '';
        if ($images = $ad->getImages()->all()) {
            foreach ($images as $i) {
                $tmp .= '<image>' . Url::to($i->getFile('image')->imageUrl, true) . '</image>';
            }
        }
        return $tmp;
    }

    /**
     * delete feed to DB
     */
    public function deleteFeed()
    {
        if ($this->ad->isNewRecord) {
            return;
        }
        $feed = ExternalPlatformFeeds::find()->where([
                    'ad_id' => $this->ad->primaryKey
                ])->one();
        if ($feed) {
            return $feed->delete();
        }
        return $feed;
    }

    /**
     * add feed to DB
     */
    public function addFeed()
    {
        $feed = ExternalPlatformFeeds::find()->where([
                    'ad_id' => $this->ad->primaryKey
                ])->one();
        if (!$feed) {
            $feed = new ExternalPlatformFeeds();
            $feed->ad_id = $this->ad->primaryKey;
            $feed->status = ExternalPlatformFeeds::STATUS_PENDING;
        }
        $feed->platform_id = $this->primaryKey;
        $feed->body = $this->getXmlBody();
        if ($feed->validate()) {
            return $feed->save();
        }
    }

}
