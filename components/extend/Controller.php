<?php

namespace app\components\extend;

use Yii;
use yii\base\InvalidParamException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

class Controller extends \yii\web\Controller
{
	public $flash;

	/**
	 *
	 * @param type $action
	 * @return type
	 */
	public function beforeAction($action)
	{
		$ba = parent::beforeAction($action);
		return $ba;
	}

	/**
	 * ajax validate model data
	 * @param LeaseContracts $model
	 */
	public function ajaxValidation($model)
	{
		if (Yii::$app->request->isAjax) {
			echo Json::encode(ActiveForm::validate($model));
			Yii::$app->end();
		}
	}

	/**
	 *
	 * @param string $message
	 * @throws NotFoundHttpException
	 */
	public function throwNoPageFound($message = 'Запрашиваемая страница не существует')
	{
		throw new \yii\web\NotFoundHttpException($message);
	}

	public static function monthLabels($number = null, $type = 1)
	{
		$number = (int)$number;

		$months = [
			1  => Yii::t('app', 'Январь'),
			2  => Yii::t('app', 'Февраль'),
			3  => Yii::t('app', 'Март'),
			4  => Yii::t('app', 'Апрель'),
			5  => Yii::t('app', 'Май'),
			6  => Yii::t('app', 'Июнь'),
			7  => Yii::t('app', 'Июль'),
			8  => Yii::t('app', 'Август'),
			9  => Yii::t('app', 'Сентябрь'),
			10 => Yii::t('app', 'Октябрь'),
			11 => Yii::t('app', 'Ноябрь'),
			12 => Yii::t('app', 'Декабрь'),
		];

		if ($type == 2) {
			$months = [
				1  => Yii::t('app', 'Января'),
				2  => Yii::t('app', 'Февраля'),
				3  => Yii::t('app', 'Марта'),
				4  => Yii::t('app', 'Апреля'),
				5  => Yii::t('app', 'Мая'),
				6  => Yii::t('app', 'Июня'),
				7  => Yii::t('app', 'Июля'),
				8  => Yii::t('app', 'Августа'),
				9  => Yii::t('app', 'Сентября'),
				10 => Yii::t('app', 'Октября'),
				11 => Yii::t('app', 'Ноября'),
				12 => Yii::t('app', 'Декабря'),
			];
		}

		if ($type == 3) {
			$months = [
				1  => Yii::t('app', 'Январе'),
				2  => Yii::t('app', 'Феврале'),
				3  => Yii::t('app', 'Марте'),
				4  => Yii::t('app', 'Апреле'),
				5  => Yii::t('app', 'Мае'),
				6  => Yii::t('app', 'Июне'),
				7  => Yii::t('app', 'Июле'),
				8  => Yii::t('app', 'Августе'),
				9  => Yii::t('app', 'Сентябре'),
				10 => Yii::t('app', 'Октябре'),
				11 => Yii::t('app', 'Ноябре'),
				12 => Yii::t('app', 'Декабре'),
			];
		}

		if ($type == 4) {
			$months = [
				1  => Yii::t('app', 'Янв'),
				2  => Yii::t('app', 'Фев'),
				3  => Yii::t('app', 'Мар'),
				4  => Yii::t('app', 'Апр'),
				5  => Yii::t('app', 'Май'),
				6  => Yii::t('app', 'Июн'),
				7  => Yii::t('app', 'Июл'),
				8  => Yii::t('app', 'Авг'),
				9  => Yii::t('app', 'Сен'),
				10 => Yii::t('app', 'Окт'),
				11 => Yii::t('app', 'Ноя'),
				12 => Yii::t('app', 'Дек'),
			];
		}

		if ($number != null) {
			if (isset($months[$number])) {
				return $months[$number];
			} else {
				throw new InvalidParamException(Yii::t('app', 'Мясяц с таким порядковым номером не найден'));
			}
		} else {
			return $months;
		}
	}

	function genererateRandomNumbers($length = 4)
	{
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}
}
