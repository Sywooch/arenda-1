<?php

namespace app\controllers;

use yii;
use app\models\CianArea;
use app\models\CianMetro;
use app\models\AvitoDistrict;
use yii\web\Controller;
use yii\helpers\Json;

class ReferenceController extends Controller
{
	public function actionCianRegion($term)
	{
		$query = CianArea::find()
			->filterWhere(['ilike', 'name', $term])
			->orderBy('name')
			->limit(20);
		$result = [];
		foreach ($query->all() as $item) {
			$result[] = [
				'value' => $item->cian_id,
				'label' => $item->name,
			];
		}
		return Json::encode($result);
	}
	
	public function actionAvitoDistrict($term, $city)
	{
		$query = AvitoDistrict::find()->alias('d')
			->joinWith(['city c'], false, 'INNER JOIN')
			->filterWhere(['ilike', 'd.name', $term])
			->andWhere(['c.name' => $city])
			->orderBy('d.name')
			->limit(20);
		$result = [];
		foreach ($query->all() as $item) {
			$result[] = [
				'value' => $item->avito_id,
				'label' => $item->name,
			];
		}
		return Json::encode($result);
	}
	
	public function actionCianMetro($term, $city)
	{
		$query = CianMetro::find()->alias('m')
			->joinWith(['area a'], false, 'INNER JOIN')
			->filterWhere(['ilike', 'm.name', $term])
			->andWhere(['a.name' => $city])
			->orderBy('m.name')
			->limit(20);
		$result = [];
		foreach ($query->all() as $item) {
			$result[] = [
				'value' => $item->cian_id,
				'label' => $item->name,
			];
		}
		return Json::encode($result);
	}
}
