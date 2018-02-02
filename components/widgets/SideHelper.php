<?php

namespace app\components\widgets;

use app\models\SideHelp;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class SideHelper extends Widget
{
	public function run()
	{
		$controller = Yii::$app->controller;

		if (!isset($controller))
			return;

		$path = Yii::$app->request->pathInfo;

		$model = SideHelp::find()->filterWhere(['like', 'url', $path])->one();//findOne(['url' => $path]);

		if ($model === null)
			return;

		$content = Html::tag('i', '', ['class' => 'icon-lamp']);
		$content .= $model->content;

		return Html::tag('p', $content, ['class' => 'h5 h-p']);
	}
}