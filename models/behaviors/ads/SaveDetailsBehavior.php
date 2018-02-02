<?php
/**
 * @author postolachiserghei
 */

namespace app\models\behaviors\ads;

use yii;
use yii\db\BaseActiveRecord;
use app\components\helpers\CommonHelper;
use app\models\Ads;
use app\models\AdAttributeValues;

/**
 * This is the behavior for details management in \app\models\Ads".
 *
 * @property Ads $owner
 */
class SaveDetailsBehavior extends \yii\base\Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function afterFind()
    {
        $this->owner->details = $this->loadDetails($this->owner->details);
    }

    public function beforeValidate()
    {
        if ($post = yii::$app->request->post('Ads')) {
            $this->owner->details = (array_key_exists('details', $post) && is_array($post['details']) && count($post['details']) > 0) ? $post['details'] : null;
        }
    }

    public function afterSave()
    {
        if ($this->owner->details) {
            foreach ($this->owner->details as $attribute => $value) {
                if (!$model = AdAttributeValues::find()->where(['ad_id' => $this->owner->primaryKey, 'attribute_id' => (int) $attribute])->one()) {
                    $model = new AdAttributeValues();
                }
                $model->ad_id = $this->owner->primaryKey;
                $model->attribute_id = (int) $attribute;
                $model->value = yii\helpers\BaseHtmlPurifier::process($value);
                if ($model->validate()) {
                    $model->save();
                }
            }
        }
    }

    /**
     * load details data
     * @param type $details
     */
    public function loadDetails($details = [], $parent = 0)
    {
        $data = AdAttributeValues::find()->where([
                    'ad_id' => $this->owner->primaryKey,
                ])->all();
        return yii\helpers\ArrayHelper::map($data, 'attribute_id', 'value');
    }

}