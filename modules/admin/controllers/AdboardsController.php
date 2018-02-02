<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\AdBoard;
use app\models\Ads;
use app\models\search\AdBoardSearch;
use app\modules\admin\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AdboardsController extends AdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AdBoardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionPreview($id)
    {
		$ads = new Ads;
		$model = $this->findModel($id);
		yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		yii::$app->response->headers->add('Content-Type', 'text/plain; charset=UTF-8');
		ob_start();
		echo $model->renderFeedHeader();
		echo $model->renderFeedElement([
			'sequence' => '1',
			'id' => '1',
			'url' => 'http://ad.url/view?id=1',
			'title' => 'Тестовое объявление 1',
			'description' => 'Максимум информации',
			'type' => $ads->getHouseTypeLabels(Ads::HOUSE_TYPE_FULL),
			'type_code' => 'full',
			'kind' => $ads->getAccommodationTypeLabels(Ads::ACCOMMODATION_TYPE_APARTMENT),
			'kind_code' => 'apartment',
			'region' => 'Москва',
			'region_id' => '1',
			'city' => 'Москва',
			'district' => '',
			'metro' => 'Авиамоторная',
			'metro_id' => '85',
			'street' => 'Авиамоторная',
			'house_number' => '1',
			'housing_number' => '2',
			'building_number' => '3',
			'apartment_number' => '4',
			'address' => 'ул. Авиамоторная, д. 1, к. 2, стр. 3',
			'area_total' => '35',
			'area_living' => '20',
			'number_of_rooms' => '2',
			'number_of_bedrooms' => '1',
			'number_of_separated_bathrooms' => '0',
			'number_of_combined_bathrooms' => '1',
			'condition' => $ads->getConditionTypeLabels(Ads::CONDITION_TYPE_FAIR),
			'condition_code' => 'average',
			'floor' => '5',
			'number_of_floors' => '16',
			'building_type' => $ads->getBuildingTypeLabels(Ads::BUILDING_TYPE_PANEL),
			'building_type_code' => 'panel',
			'number_of_passenger_elevators' => '1',
			'number_of_cargo_elevators' => '0',
			'allow_pets' => 'allow',
			'allowed_pets' => array_map(function($v) use($ads) {
				return  $ads->getPetsAllowedLabels($v);
			}, [Ads::PETS_ALLOWED_CATS, Ads::PETS_ALLOWED_DOGS]),
			'allowed_pets_codes' => ['cats', 'dogs'],
			'facilities' => array_map(function($v) use($ads) {
				return $ads->getFacilitiesLabels($v);
			}, [Ads::FACILITIES_BATHROOM, Ads::FACILITIES_TV]),
			'facilities_codes' => ['bathroom', 'tv'],
			'other_facilities' => 'Коврик "Welcome" красный',
			'phone' => '+7 123 456 789',
			'price' => '10000',
			'min_term' => '6',
			'deposit' => '10000',
			'deposit_month' => '1',
			'images' => [
				'http://ad.url/image1.jpg',
				'http://ad.url/image2.jpg',
				'http://ad.url/image3.jpg',
			],
			'created_at' => date('c'),
			'updated_at' => date('c'),
			'expires_at' => date('c', time() + 2678400),
			'date_created_at' => date('Y-m-d'),
			'date_updated_at' => date('Y-m-d'),
			'date_expires_at' => date('Y-m-d', time() + 2678400),
		]);
		echo $model->renderFeedElement([
			'sequence' => '2',
			'id' => '2',
			'url' => 'http://ad.url/view?id=2',
			'title' => 'Тестовое объявление 2',
			'description' => 'Минимум информации',
			'type' => $ads->getHouseTypeLabels(Ads::HOUSE_TYPE_FULL),
			'type_code' => 'full',
			'kind' => $ads->getAccommodationTypeLabels(Ads::ACCOMMODATION_TYPE_APARTMENT),
			'kind_code' => 'apartment',
			'region' => '',
			'region_id' => '',
			'city' => 'Москва',
			'district' => '',
			'metro' => '',
			'metro_id' => '',
			'street' => 'Авиамоторная',
			'house_number' => '',
			'housing_number' => '',
			'building_number' => '',
			'apartment_number' => '',
			'address' => 'ул. Авиамоторная',
			'area_total' => '35',
			'area_living' => '',
			'number_of_rooms' => '2',
			'number_of_bedrooms' => '1',
			'number_of_separated_bathrooms' => '0',
			'number_of_combined_bathrooms' => '0',
			'condition' => $ads->getConditionTypeLabels(Ads::CONDITION_TYPE_FAIR),
			'condition_code' => 'average',
			'floor' => '',
			'number_of_floors' => '',
			'building_type' => $ads->getBuildingTypeLabels(Ads::BUILDING_TYPE_PANEL),
			'building_type_code' => 'panel',
			'number_of_passenger_elevators' => '0',
			'number_of_cargo_elevators' => '0',
			'allow_pets' => '',
			'allowed_pets' => [],
			'allowed_pets_codes' => [],
			'facilities' => [],
			'facilities_codes' => [],
			'other_facilities' => '',
			'phone' => '+7 123 456 789',
			'price' => '10 000',
			'min_term' => '',
			'deposit' => '',
			'deposit_month' => '',
			'images' => [],
			'created_at' => date('c'),
			'updated_at' => date('c'),
			'expires_at' => date('c', time() + 2678400),
			'date_created_at' => date('Y-m-d'),
			'date_updated_at' => date('Y-m-d'),
			'date_expires_at' => date('Y-m-d', time() + 2678400),
		]);
		echo $model->renderFeedFooter();
		return ob_get_clean();
    }

    public function actionCreate()
    {
        $model = new AdBoard();
        $model->prices = [[
			'label' => 'Стандарт',
			'code' => AdBoard::STD_PRICE,
			'price' => '',
        ]];
        $model->validation = [
			'region' => AdBoard::VALIDATION_OPTIONAL,
			'city' => AdBoard::VALIDATION_OPTIONAL,
			'district' => AdBoard::VALIDATION_OPTIONAL,
			'metro' => AdBoard::VALIDATION_OPTIONAL,
			'street' => AdBoard::VALIDATION_OPTIONAL,
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->validation = array_merge([
			'region' => AdBoard::VALIDATION_OPTIONAL,
			'city' => AdBoard::VALIDATION_OPTIONAL,
			'district' => AdBoard::VALIDATION_OPTIONAL,
			'metro' => AdBoard::VALIDATION_OPTIONAL,
			'street' => AdBoard::VALIDATION_OPTIONAL,
        ], $model->validation);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = AdBoard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
