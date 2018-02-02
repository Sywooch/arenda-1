<?php

namespace app\components\extend;

use yii\helpers\Html as BaseHtml;
use app\components\helpers\CommonHelper;
use yii\helpers\ArrayHelper;


class Html extends BaseHtml
{

    public static function tag($name, $content = '', $options = array())
    {
        return parent::tag($name, CommonHelper::str()->replaceTagsWithDatatValues($content, $options), $options);
    }

	public static function activeDataLabel($model, $attribute, $options = [])
	{
		$for = ArrayHelper::remove($options, 'for', static::getInputId($model, 'data' . $attribute));

		$label = ArrayHelper::remove($options, 'label', static::encode($model->getDataLabels($attribute)));
		return static::label($label, $for, $options);
	}
}
