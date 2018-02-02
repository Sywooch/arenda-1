<?php

namespace app\models;

use yii;
use app\components\helpers\CommonHelper;
use yii\helpers\Json;
use app\components\extend\Html;
use app\components\extend\Url;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property integer $id
 * @property integer $real_estate_id
 * @property string $title
 * @property string $description
 * @property integer $house_type
 * @property integer $accommodation_type
 * @property integer $number_of_bedrooms
 * @property integer $separate_bathroom
 * @property integer $combined_bathroom
 * @property integer $house_floors
 * @property integer $location_floor
 * @property integer $building_type
 * @property integer $number_of_rooms
 * @property integer $condition
 * @property integer $watch_statistics
 * @property string $rent_cost_per_month
 * @property integer $rent_term
 * @property integer $rent_available_date
 * @property integer $rent_pledge
 * @property integer $check_credit_reports
 * @property integer $check_biographical_information
 * @property integer $status
 * @property array $details
 * @property integer $number_of_rooms_total_area
 * @property behaviors\ads\IntegrationBehavior $integration
 *
 * @property RealEstate $estate
 * @property AdViewedCounter $adViewedCounter
 * @property Pay $pay
 */
class Ads extends \app\components\extend\ActiveRecord
{
    public $facilities2;
    const SCENARIO_STEP_1 = 'step_1';
    const SCENARIO_STEP_2 = 'step_2';
    const SCENARIO_STEP_3 = 'step_3';
    const SCENARIO_STEP_4 = 'step_4';
    const SCENARIO_STEP_5 = 'step_5';
    const SCENARIO_STEP_6 = 'step_6';

    const STEPS_COUNT = 6;

    const STATUS_DISABLED = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DRAFT = 5;

    const HOUSE_TYPE_FULL = 1;
    const HOUSE_TYPE_ROOM = 2;
    const HOUSE_TYPE_ROOM_COMMON = 3;
    const ACCOMMODATION_TYPE_APARTMENT = 1;
    const ACCOMMODATION_TYPE_NEW_BUILDING = 2;
    const ACCOMMODATION_TYPE_ROOM = 3;
    const ACCOMMODATION_TYPE_FLAT_PART = 4;
    const ACCOMMODATION_TYPE_HOUSE = 5;
    const ACCOMMODATION_TYPE_COTTAGE = 6;
    const ACCOMMODATION_TYPE_TOWNHOUSE = 7;
    const ACCOMMODATION_TYPE_HOUSE_PART = 8;
    const ACCOMMODATION_TYPE_LOT = 9;
    const BUILDING_TYPE_BRICK = 1;
    const BUILDING_TYPE_MONOLITH = 2;
    const BUILDING_TYPE_PANEL = 3;
    const BUILDING_TYPE_BLOCK = 4;
    const BUILDING_TYPE_WOOD = 5;
    const BUILDING_TYPE_MONO_BRICK = 6;
    const BUILDING_TYPE_STALIN = 7;
    const CONDITION_TYPE_BAD = 1;
    const CONDITION_TYPE_FAIR = 2;
    const CONDITION_TYPE_GOOD = 3;
    const CONDITION_TYPE_EXCELLENT = 4;
    const PLACE_TO_AVITO = 'avito';
    const PLACE_TO_CIAN = 'cian';
    const PLACE_TO_SNIMUDOM = 'snimudom';
    const PETS_CONDITION_NOT_ALLOWED = 0;
    const PETS_CONDITION_ALLOWED = 1;
    const PETS_CONDITION_UNDEFINED = 2;
    const PETS_ALLOWED_CATS = 1;
    const PETS_ALLOWED_DOGS = 2;
    const FACILITIES_BATHROOM = 1;
    const FACILITIES_TV = 2;
    const FACILITIES_PARKING = 3;
    const FACILITIES_GARBAGE_CHUTE = 4;
    const FACILITIES_PC = 5;
    const FACILITIES_WARDROBE = 6;
    const FACILITIES_DINNER_TABLE = 7;
    const FACILITIES_REFRIGERATOR = 8;
    const FACILITIES_GAS_STOVE = 9;
    const FACILITIES_MICROWAVE = 10;
    const FACILITIES_WASHER = 11;
    const FACILITIES_BALCONY = 12;
    const FACILITIES_FIREPLACE = 13;
    const FACILITIES_CUPBOARD = 14;
    const FACILITIES_AIR_CONDITIONING = 15;
    const FACILITIES_CONCIERGE = 16;
    const FACILITIES_BED = 21;
    const FACILITIES_DOUBLE_BED = 22;
    const FACILITIES_SOFA = 22;
    const FACILITIES_ELEXTRIC_STOVE = 23;
    const RENT_AVAILABLE_UNDEFINED = 0;
    const RENT_AVAILABLE_AVAILABLE_NOW = 1;
    const RENT_AVAILABLE_AVAILABLE_DATE = 2;

    public $images;
    public $details;
    public $place_add_to;

    public static function getFacilitiesLabels($place = false)
    {
        $ar = [
            self::FACILITIES_BATHROOM => 'Ванна',
            self::FACILITIES_PARKING => 'Парковка',
            self::FACILITIES_GARBAGE_CHUTE => 'Мусоропровод',
            self::FACILITIES_BALCONY => 'Балкон/Лоджия',
            self::FACILITIES_FIREPLACE => 'Камин',
            self::FACILITIES_CONCIERGE => 'Консьерж',
        ];

        if($place!=false AND isset($ar[$place])){
            $p = $ar[$place];
        }else{
            $p = null;
        }

        return $place !== false ? $p : $ar;
    }

    public static function getFacilities2Labels($place = false)
    {
        $ar = [
            self::FACILITIES_CUPBOARD => 'Шкаф',
            self::FACILITIES_BED => 'Кровать',
            self::FACILITIES_DOUBLE_BED =>'Двуспальная кровать',
            self::FACILITIES_DINNER_TABLE => 'Обеденный стол',
            self::FACILITIES_SOFA=>'Диван',

            self::FACILITIES_TV => 'Телевизор',
            self::FACILITIES_REFRIGERATOR => 'Холодильник',
            self::FACILITIES_WASHER => 'Стиральная машина',
            self::FACILITIES_WASHER => 'Посудомоечная машина',
            self::FACILITIES_GAS_STOVE => 'Газовая плита',
            self::FACILITIES_ELEXTRIC_STOVE=>'Электрическая плита',
            self::FACILITIES_AIR_CONDITIONING => 'Кондиционер',
        ];

        if($place!=false AND isset($ar[$place])){
            $p = $ar[$place];
        }else{
            $p = null;
        }

        return $place !== false ? $p : $ar;
    }

    public static function getFacilitiesAllLabels($place = false)
    {
        $ar = [
            self::FACILITIES_BATHROOM => 'Ванна',
            self::FACILITIES_PARKING => 'Парковка',
            self::FACILITIES_GARBAGE_CHUTE => 'Мусоропровод',
            self::FACILITIES_BALCONY => 'Балкон/Лоджия',
            self::FACILITIES_FIREPLACE => 'Камин',
            self::FACILITIES_CONCIERGE => 'Консьерж',

            self::FACILITIES_CUPBOARD => 'Шкаф',
            self::FACILITIES_BED => 'Кровать',
            self::FACILITIES_DOUBLE_BED =>'Двуспальная кровать',
            self::FACILITIES_DINNER_TABLE => 'Обеденный стол',
            self::FACILITIES_SOFA=>'Диван',

            self::FACILITIES_TV => 'Телевизор',
            self::FACILITIES_REFRIGERATOR => 'Холодильник',
            self::FACILITIES_WASHER => 'Стиральная машина',
            self::FACILITIES_WASHER => 'Посудомоечная машина',
            self::FACILITIES_GAS_STOVE => 'Газовая плита',
            self::FACILITIES_ELEXTRIC_STOVE=>'Электрическая плита',
            self::FACILITIES_AIR_CONDITIONING => 'Кондиционер',
        ];

        if($place!=false AND isset($ar[$place])){
            $p = $ar[$place];
        }else{
            $p = null;
        }

        return $place !== false ? $p : $ar;
    }

    public static function getRentAvailableLabels($type = false)
    {
        $ar = [
            self::RENT_AVAILABLE_UNDEFINED => 'Не указывать',
            self::RENT_AVAILABLE_AVAILABLE_NOW => 'Доступна сейчас',
            self::RENT_AVAILABLE_AVAILABLE_DATE => 'Точная дата',
        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    public static function getPetsConditionLabels($type = false)
    {
        $ar = [
            self::PETS_CONDITION_NOT_ALLOWED => 'Запрещается',
            self::PETS_CONDITION_ALLOWED => 'Разрешается',
            self::PETS_CONDITION_UNDEFINED => 'Не указывать',
        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    public static function getPetsAllowedLabels($type = false)
    {
        $ar = [
            self::PETS_ALLOWED_CATS => 'Кошки',
            self::PETS_ALLOWED_DOGS => 'Собаки',
        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    /**
     * @param integer /boolean $type
     * @return type
     */
    public static function getConditionTypeLabels($type = false)
    {
        $ar = [
            self::CONDITION_TYPE_GOOD => 'Хорошее',
            self::CONDITION_TYPE_EXCELLENT => 'Отличное',
            self::CONDITION_TYPE_FAIR => 'Среднее',
            self::CONDITION_TYPE_BAD => 'Плохое',
        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    /**
     * @param integer /boolean $type
     * @return type
     */
    public static function getBuildingTypeLabels($type = false)
    {
        $ar = [
            self::BUILDING_TYPE_BRICK => 'Кирпичный',
            self::BUILDING_TYPE_MONOLITH => 'Монолитный',
            self::BUILDING_TYPE_PANEL => 'Панельный',
            self::BUILDING_TYPE_BLOCK => 'Блочный',
            self::BUILDING_TYPE_WOOD => 'Деревянный',
            self::BUILDING_TYPE_MONO_BRICK => 'Монолитно-кирпичный',
            self::BUILDING_TYPE_STALIN => 'Сталинский',

        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    /**
     * @param integer /boolean $type
     */
    public static function getAccommodationTypeLabels($type = false)
    {
        $ar = [
            self::ACCOMMODATION_TYPE_APARTMENT => 'Квартира',
            self::ACCOMMODATION_TYPE_NEW_BUILDING => 'В новостройке',
            self::ACCOMMODATION_TYPE_ROOM => 'Комната',
            self::ACCOMMODATION_TYPE_FLAT_PART => 'Доля в квартире',
            self::ACCOMMODATION_TYPE_HOUSE => 'Дом/Дача',
            self::ACCOMMODATION_TYPE_COTTAGE => 'Коттедж',
            self::ACCOMMODATION_TYPE_TOWNHOUSE => 'Таунхаус',
            self::ACCOMMODATION_TYPE_HOUSE_PART => 'Часть дома',
            self::ACCOMMODATION_TYPE_LOT => 'Участок',
        ];

        if($type!=false AND isset($ar[$type])){
            $p = $ar[$type];
        }else{
            $p = null;
        }
        return $type !== false ? $p : $ar;
    }

    public function locationFloorValidate($attribute, $params)
    {
        if ($this->$attribute > $this->house_floors) {
            $this->addError($attribute, 'Этаж расположения не может быть больше Этажности дома');
        }
    }

    /**
     * @param boolean $status
     * @return mixed
     */
    public function getStatusLabels($status = false)
    {
        $ar = [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_DISABLED => 'Не активно',
        ];

        return $status !== false ? $ar[$status] : $ar;
    }

    /**
     * @param boolean $type
     * @return mixed
     */
    public function getHouseTypeLabels($type = false)
    {
        $ar = [
            self::HOUSE_TYPE_FULL => ' Жилье целиком',
            self::HOUSE_TYPE_ROOM => ' Отдельная комната',
            self::HOUSE_TYPE_ROOM_COMMON => ' Общая комната',
        ];

        if ($type === 0) {
            return $ar[1];
        }

        return $type !== false ? $ar[$type] : $ar;
    }

    public function getPay()
    {
        return $this->hasOne(Pay::className(), ['objectId' => 'id'])->andOnCondition(['typeId' => Pay::TYPE_AD]);
    }

    /**
     * @return Pay|null
     */
    public function pay()
    {
        /** @var  $pay Pay */
        $pay = $this->getPay()->one();

        if ($pay && $pay->statusReject()) {
            $pay = null;
        }

        if ($pay == null) {
            $pay = new Pay();
            $pay->create($this);
        }

        return $pay;
    }


    public function getCover()
    {
        $image = $this->getImages()->where(['cover' => 1])->one();

        return $image ? $image : new AdImages();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(AdImages::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublications()
    {
        return $this->hasMany(AdPublication::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstate()
    {
        return $this->hasOne(RealEstate::className(), ['id' => 'real_estate_id']);
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $af = parent::afterFind();

        if (!empty($this->facilities)) {
            $fs = explode(',', $this->facilities);

            $tTmp = [];

            foreach ($fs as $f) {
                if (!empty($f)) {
                    $tTmp[] = $f;
                }
            }

            $this->facilities = $tTmp;
        } else {
            $this->facilities = [];
        }

        if (!empty($this->pets_allowed_list)) {
            $fs = explode(',', $this->pets_allowed_list);

            $tTmp = [];

            foreach ($fs as $f) {
                if (!empty($f)) {
                    $tTmp[] = $f;
                }
            }

            $this->pets_allowed_list = $tTmp;
        } else {
            $this->pets_allowed_list = [];
        }

	    if ($this->json != null) {
		    $this->json = json_decode($this->json, true);
	    } else {
		    $this->json = [];
	    }

	    if (isset($this->json['place_add_to'])) {
		    $this->place_add_to = $this->json['place_add_to'];
	    }

	    return $af;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'title' => 'Например: однокомнтная квартира в центре',
            'description' => 'Чем вы отличаетесь от других?',
            'place_add_to' => 'Хотели бы дополнительно разместить объявления на других ресурсах?',
            'watch_statistics' => 'Хотеле бы вы следить за статистикой посещения вашего объявление?',
            'check_credit_reports' => 'Все кандидаты будут предложено представить отчет о кредитных операциях с их применением. Включает в себя кредитный счет, подробную историю платежей и задолженности обзоры.',
            'check_biographical_information' => 'Все кандидаты будут предложено запустить проверку как часть их применения. Включает в себя поиск и выселении национальных / графства судимости.',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'real_estate_id' => 'Недвижимость',
            'title' => 'Название',
            'description' => 'Описание',
            'house_type' => 'К какому типу размещения относится ваше жилье',
            'accommodation_type' => 'Какой это тип жилья',
            'number_of_bedrooms' => 'Количество спален',
            'separate_bathroom' => 'Раздельные санузлы',
            'combined_bathroom' => 'Совмещенные санузлы',
            'house_floors' => 'Этажность дома',
            'location_floor' => 'Этаж расположения',
            'building_type' => 'Тип дома',
            'number_of_rooms' => 'Количество комнат',
            'number_of_rooms_total_area' => 'Общая площадь',
            'number_of_rooms_living_area' => 'Жилая площадь',
            'condition' => 'Состояние недвижимости',
            'place_add_to' => 'Размещение объявления',
            'watch_statistics' => 'Установить статистику',
            'rent_cost_per_month' => 'Стоимость в месяц',
            'rent_term' => 'Минимальный срок',
            'rent_available' => 'Доступность недвижимости',
            'rent_available_date' => 'Доступность недвижимости. Точная дата',
            'rent_pledge' => 'Залог',
            'check_credit_reports' => 'Отчеты о кредитных операциях',
            'check_biographical_information' => 'Биографические данные',
            'images' => 'Фото',
            'status' => 'Статус',
            'elevator_passenger' => 'Пассажирских лифтов',
            'elevator_service' => 'Грузовых лифтов',
            'pets_condition' => 'Домашние животные',
            'pets_allowed_list' => 'Разрешенные животные',
            'facilities' => 'Удобства',
            'facilities2' => 'Мебель и техника',
            'facilities_other' => 'Другие удобства',
            'rent_term_undefined' => 'Не указывать',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $bd = parent::beforeDelete();
        $this->deleteImages();
        $this->deletePublications();
        return $bd;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (isset($changedAttributes['status']) && $this->status == self::STATUS_ACTIVE) {
            if ($this->estate->check_status == RealEstate::CHECK_STATUS_NOT_RUN)
                $this->estate->updateAttributes(['check_status' => RealEstate::CHECK_STATUS_START]);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * delete ads (neded to delete files)
     */
    public function deleteImages()
    {
        if ($images = $this->getImages()->all()) {
            foreach ($images as $image) {
                /* @var $image AdImages */
                $image->delete();
            }
        }
    }

    public function deletePublications()
    {
        foreach ($this->getPublications()->all() as $publication) {
            $publication->delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);

        if (is_array($this->facilities)) {
            $this->facilities = ',' . implode(',', $this->facilities) . ',';
        } elseif (empty($this->facilities)) {
            $this->facilities = null;
        }

        if ($this->pets_condition == self::PETS_CONDITION_ALLOWED) {
            if (is_array($this->pets_allowed_list) && !empty($this->pets_allowed_list)) {
                $this->pets_allowed_list = ',' . implode(',', $this->pets_allowed_list) . ',';
            }
        } else {
            $this->pets_allowed_list = '';
        }

	    $this->json = json_encode(array(
	    	'place_add_to' => $this->place_add_to,
	    ));

        return $bs;
    }

    public function beforeValidate()
    {
        $this->rent_cost_per_month = str_replace(' ', '', $this->rent_cost_per_month);

        $this->convertDateToUnix();

        $this->rent_pledge = str_replace(' ', '', $this->rent_pledge);

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    /**
     * convert date from string to unix time
     */
    public function convertDateToUnix()
    {
        if (!is_numeric($this->rent_available_date) && $this->rent_available_date != '') {
            $this->rent_available_date = strtotime($this->rent_available_date);
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'date_created',
                    'updatedAtAttribute' => 'date_updated',
                ],
                [
                    'class' => behaviors\common\SaveFilesBehavior::className(),
                    'fileAttributes' => ['images'],
                    'saveFileForOwner' => false,
                    'afterFileSave' => function (Ads $owner, Files $file) {
                        $model = new AdImages();
                        $model->image = $file->id;
                        $model->ad_id = $owner->primaryKey;
                        if (isset($_GET['cover'])) {
                            $covers = AdImages::updateAll(['cover' => 0], ['ad_id' => $model->ad_id, 'cover' => 1]);
                            $model->cover = 1;
                        }

                        return $model->save();
                    },
                ],
                [
                    'class' => behaviors\ads\SaveDetailsBehavior::className(),
                ],
                //behaviors\ads\IntegrationBehavior::className(),
            ] + parent::behaviors();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        ['rent_pledge', 'filter', 'filter' => 'intval'],
            [
                [
                    'title',
	                'description',
                    'building_type',
                    'rent_cost_per_month',
                    'number_of_rooms_total_area',
                    'real_estate_id',
                    'house_type',
                    'accommodation_type',
                    'number_of_bedrooms',
                    'status',
                ],
                'required',
            ],
            [
                [
                    'status',
                    'number_of_rooms_total_area',
                    'elevator_passenger',
                    'elevator_service',
                    'number_of_rooms_living_area',
                    'real_estate_id',
                    'house_type',
                    'accommodation_type',
                    'number_of_bedrooms',
                    'separate_bathroom',
                    'combined_bathroom',
                    'house_floors',
                    'location_floor',
                    'building_type',
                    'number_of_rooms',
                    'condition',
                    'watch_statistics',
                    'rent_term',
                    'rent_available_date',
                    'rent_pledge',
                    'check_credit_reports',
                    'check_biographical_information',
                    'pets_condition',
                    'rent_term_undefined',
                    'rent_available',
                ],
                'integer',
            ],
            [['description'], 'string'],
            [['pets_allowed_list', 'facilities', 'facilities2'], 'safe'],
            ['pets_allowed_list', 'default', 'value' => null],
            [['facilities_other'], 'string', 'max' => 255],
            [['rent_cost_per_month'], 'number'],
            [['number_of_rooms_total_area'], 'number', 'min' => 10],
            [['details'], 'string'],
            [['title'], 'string', 'max' => 255],
            [
                ['images'],
                'file',
                'skipOnEmpty' => true,
                'maxFiles' => 5,
                'extensions' => Files::imageExtension(),
                'on' => self::SCENARIO_FILE_UPLOAD,
            ],
            [
                ['real_estate_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => RealEstate::className(),
                'targetAttribute' => ['real_estate_id' => 'id'],
            ],
            [['images', 'details', 'json'], 'safe'],
            ['location_floor', 'locationFloorValidate'],
            [['place_add_to'], 'validateAdboardsRequirements']
        ];
    }

    public function scenarios()
    {
        $parentScenarios = parent::scenarios();

        $step_1 = [
            'title',
            'description',
            'house_type',
            'accommodation_type',
            'number_of_rooms',
            'number_of_rooms_total_area',
            'number_of_rooms_living_area',
            'number_of_bedrooms',
            'separate_bathroom',
            'combined_bathroom',
            'condition',
            'house_floors',
            'location_floor',
            'elevator_passenger',
            'elevator_service',
            'building_type',
        ];
        $step_2 = ['pets_condition', 'pets_allowed_list', 'facilities', 'facilities_other'];
        $step_3 = [
            'rent_cost_per_month',
            'rent_term',
            'rent_term_undefined',
            'rent_available',
            'rent_available_date',
            'rent_pledge',
        ];
        $step_4 = ['images'];
        $step_5 = ['check_credit_reports', 'check_biographical_information'];
        $step_6 = [
            'status',
            'place_add_to',
            'watch_statistics',
        ];

        return [
            self::SCENARIO_DEFAULT => $parentScenarios[self::SCENARIO_DEFAULT],
            self::SCENARIO_FILE_UPLOAD => ['images'],
            self::SCENARIO_STEP_1 => $step_1,
            self::SCENARIO_STEP_2 => array_merge($step_1, $step_2),
            self::SCENARIO_STEP_3 => array_merge($step_1, $step_2, $step_3),
            self::SCENARIO_STEP_4 => array_merge($step_1, $step_2, $step_3, $step_4),
            self::SCENARIO_STEP_5 => array_merge($step_1, $step_2, $step_3, $step_4, $step_5),
            self::SCENARIO_STEP_6 => array_merge($step_1, $step_2, $step_3, $step_4, $step_5, $step_6),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ads}}';
    }

    public function hasFacility($facility = null)
    {
        if ($facility != null) {
            return in_array($facility, (array) $this->facilities) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * ВОзвращает стоимость аренды в месяц
     * @return string
     */
    public function getRentCostPerMonth()
    {
        return CommonHelper::getPrice($this->rent_cost_per_month) . ' в мес.';
    }

    public function getRentCostPerYear()
    {
        return CommonHelper::getPrice($this->rent_cost_per_month * 12) . ' в год';
    }

    /**
     * get today views
     * @return integer
     */
    public function countTodayViews()
    {
        $date = date('U', strtotime('yesterday midnight'));
        $sum = $this->getAdViewedCounter()->where('date_created>=:d', [
            'd' => $date,
        ])->sum('views');

        return $sum ? $sum : 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdViewedCounter()
    {
        return $this->hasMany(AdViewedCounter::className(), ['ad_id' => 'id']);
    }

    /**
     * get all views
     * @return integer
     */
    public function countAllViews()
    {
        $sum = $this->getAdViewedCounter()->sum('views');

        return $sum ? $sum : 0;
    }

    /**
     * get values for drop down
     * @return array
     */
    public function getTenPlus()
    {
        $r = range(1, 10);

        return array_combine($r, $r) + [
                11 => '10+',
            ];
    }

    /**
     * get number of rooms
     * @return string
     */
    public function getNumberOfRooms()
    {
        return Yii::t('app', '{n, plural, =1{# комната} =2{# комнаты} =3{# комнаты} =4{# комнаты} other{# комнат}}',
            ['n' => (int)$this->number_of_rooms]);
    }

    public function getNumberOfRoomsSpellout()
    {

        return Yii::t('app', '{n,spellout,%spellout-cardinal-feminine}',
            ['n' => (int)$this->number_of_rooms]);
    }

    /**
     * get number of bathrooms
     * @return string
     */
    public function getNumberOfBathrooms()
    {
        if ((int)($this->combined_bathroom + $this->separate_bathroom) == 0) {
            return '';
        }

        return Yii::t('app',
            '{n, plural, =1{# ванная комната} =2{# ванные комнаты} =3{# ванные комнаты} =4{# ванные комнаты} other{# ванныx комнат}}',
            [
                'n' => (int)($this->combined_bathroom + $this->separate_bathroom),
            ]);
    }

    /**
     * get number of bathrooms
     * @return string
     */
    public function getNumberOfCombinedBathrooms()
    {
        if ($this->combined_bathroom == 0) {
            return '';
        }

        return Yii::t('app',
            '{n, plural, =1{# совмещенный санузел} =2{# совмещенных санузла} =3{# совмещенных санузла} =4{# совмещенных санузла} other{# совмещенных санузлов}}',
            [
                'n' => (int)$this->combined_bathroom,
            ]);
    }

    /**
     * get number of bathrooms
     * @return string
     */
    public function getNumberOfSeparateBathrooms()
    {
        if ($this->separate_bathroom == 0) {
            return '';
        }

        return Yii::t('app',
            '{n, plural, =1{# раздельный санузел} =2{# раздельных санузла} =3{# раздельных санузла} =4{# раздельных санузла} other{# раздельных санузлов}}',
            [
                'n' => (int)$this->separate_bathroom,
            ]);
    }

    /**
     * get number of bedrooms
     * @return string
     */
    public function getNumberOfBedrooms()
    {
        return Yii::t('app', '{n, plural, =1{# спальня} =2{# спальни} =3{# спальни} =4{# спальни} other{# спален}}', [
            'n' => (int)$this->number_of_bedrooms,
        ]);
    }

    /**
     * get total area
     * @return string
     */
    public function getTotalArea()
    {
        return $this->number_of_rooms_total_area;
    }

    /**
     * get rent term
     * @return string
     */
    public function getRentTerm()
    {
        if ($this->rent_term == 0) {
            return '';
        }

        return $this->rent_term . ' мес.';
    }

    public function getRentAvailable()
    {
        if ($this->rent_available == self::RENT_AVAILABLE_AVAILABLE_DATE) {
            return 'с ' . $this->getDate('rent_available_date', 'd.m.y');
        }

        if ($this->rent_available == self::RENT_AVAILABLE_AVAILABLE_NOW) {
            return 'Cейчас';
        }

        return '';
    }

    /*
     * get rent available
     * @return string
     */

    public function getRentPledge()
    {
        if ((int)$this->rent_pledge <= 0) {
            return '';
        }

        return CommonHelper::getPrice($this->rent_pledge);
    }

    /*
     * get rent pledge
     * @return string
     */

    /**
     * add to view counter
     * @return boolean
     */
    public function addToViewCounter()
    {
        if ($this->estate && (Yii::$app->user->id != $this->estate->user_id)) {
            $key = Yii::$app->user->id . '-viewed-add-' . $this->primaryKey;
            if (CommonHelper::data()->getCookie($key, false) !== false) {
                return null;
            }
            $date = date('U', strtotime('yesterday midnight'));
            $model = AdViewedCounter::find()->where('ad_id=:adid AND (date_created>=:d)', [
                'd' => $date,
                'adid' => $this->primaryKey,
            ])->one();
            if (!$model) {
                $model = new AdViewedCounter();
            }
            $model->views = ((int)$model->views + 1);
            $model->ad_id = $this->primaryKey;
            if ($model->validate()) {
                CommonHelper::data()->setCookie($key, 1);

                return $model->save();
            }
        }
    }

    /**
     * get today applications counter
     * @return integer
     */
    public function getApplicationsCountToday()
    {
        $date = date('U', strtotime('yesterday midnight'));

        $c = $this->getApplications()->where('(date_created >= :d)', [
            'd' => $date,
        ])->count();

        return (int)$c > 0 ? $c : 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['ad_id' => 'id']);
    }

    /**
     * get applications counter for a week
     * @return integer
     */
    public function getApplicationsCountWeek()
    {
        $date = date('U', strtotime('-1 week'));
        $c = $this->getApplications()->where('(date_created >= :d)', [
            'd' => $date,
        ])->count();

        return (int)$c > 0 ? $c : 0;
    }

    /**
     * get applications counter for all times
     * @return integer
     */
    public function getApplicationsCount()
    {
        $c = $this->getApplications()->count();

        return (int)$c > 0 ? $c : 0;
    }

    /**
     * get new applications counter
     * @return integer
     */
    public function getNewApplicationsCount()
    {
        $c = $this->getApplications()->where(['is_new' => 1])->count();

        return (int)$c > 0 ? $c : 0;
    }

    /**
     * get application of current user if such application exists
     * @return Applications
     */
    function getMyApplication()
    {
        if (Yii::$app->user->isGuest) {
            return new Applications;
        }
        $model = $this->getApplications()->where('user_id=:uid', [
            'uid' => Yii::$app->user->id,
        ])->one();

        return $model ? $model : new Applications();
    }

    /**
     * get ad site url
     * @param boolean $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::to(['/ads/view', 'id' => $this->primaryKey], $scheme);
    }

    /**
     * get all available external platforms
     * @return ExternalPlatforms
     */
    public function getAvailablePlatforms()
    {
        return ExternalPlatforms::find()->where([
            'status' => ExternalPlatforms::STATUS_ACTIVE,
        ])->all();
    }

    public function validateRestCostPerMonth($attribute)
    {
        if ($this->{$attribute} > 3267) {
            $this->addError($attribute, 'Пароль не может совпадать с логином');
        }
    }

    /**
     * get data that will be used in feed
     * @param AdBoard $board
     * @return array
     */
    public function getFeedData($board)
    {
        $estate = $this->estate;
        $owner = $estate->user;
        return [
            'id' => $this->id,
            'url' => $this->getUrl(true),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->getHouseTypeLabels($this->house_type),
            'type_code' => strtr($this->house_type, [
                self::HOUSE_TYPE_FULL => 'full',
                self::HOUSE_TYPE_ROOM => 'room',
                self::HOUSE_TYPE_ROOM_COMMON => 'common_room',
            ]),
            'kind' => $this->getAccommodationTypeLabels($this->accommodation_type),
            'kind_code' => strtr($this->accommodation_type, [
                self::ACCOMMODATION_TYPE_APARTMENT => 'apartment',
                self::ACCOMMODATION_TYPE_NEW_BUILDING => 'new_building',
                self::ACCOMMODATION_TYPE_ROOM => 'room',
                self::ACCOMMODATION_TYPE_FLAT_PART => 'flat_part',
                self::ACCOMMODATION_TYPE_HOUSE => 'house',
                self::ACCOMMODATION_TYPE_COTTAGE => 'cottage',
                self::ACCOMMODATION_TYPE_TOWNHOUSE => 'townhouse',
                self::ACCOMMODATION_TYPE_HOUSE_PART => 'house_part',
                self::ACCOMMODATION_TYPE_LOT => 'lot',
            ]),
            'region' => $estate->region,
            'region_id' => $estate->region_id,
            'city' => $estate->city,
            'district' => $estate->district,
            'metro' => $estate->metro,
            'metro_id' => $estate->metro_id,
            'street' => $estate->street,
            'house_number' => $estate->dom,
            'housing_number' => $estate->corps,
            'building_number' => $estate->building,
            'apartment_number' => $estate->flat,
            'address' => $estate->getAddressLine(),
            'area_total' => $this->number_of_rooms_total_area,
            'area_living' => $this->number_of_rooms_living_area,
            'number_of_rooms' => $this->number_of_rooms,
            'number_of_bedrooms' => $this->number_of_bedrooms,
            'number_of_separated_bathrooms' => $this->separate_bathroom,
            'number_of_combined_bathrooms' => $this->combined_bathroom,
            'condition' => $this->getConditionTypeLabels($this->condition),
            'condition_code' => strtr($this->condition, [
                self::CONDITION_TYPE_GOOD => 'good',
                self::CONDITION_TYPE_EXCELLENT => 'excellent',
                self::CONDITION_TYPE_FAIR => 'average',
                self::CONDITION_TYPE_BAD => 'bad',
            ]),
            'floor' => $this->location_floor,
            'number_of_floors' => $this->house_floors,
            'building_type' => $this->getBuildingTypeLabels($this->building_type),
            'building_type_code' => strtr($this->building_type, [
                self::BUILDING_TYPE_BRICK => 'brick',
                self::BUILDING_TYPE_MONOLITH => 'monolith',
                self::BUILDING_TYPE_PANEL => 'panel',
                self::BUILDING_TYPE_BLOCK => 'block',
                self::BUILDING_TYPE_WOOD => 'wood',
                self::BUILDING_TYPE_MONO_BRICK => 'mono_brick',
                self::BUILDING_TYPE_STALIN => 'stalin',
            ]),
            'number_of_passenger_elevators' => $this->elevator_passenger,
            'number_of_cargo_elevators' => $this->elevator_service,
            'allow_pets' => strtr($this->pets_condition, [
                self::PETS_CONDITION_NOT_ALLOWED => 'disallow',
                self::PETS_CONDITION_ALLOWED => 'allow',
                self::PETS_CONDITION_UNDEFINED => '',
            ]),
            'allowed_pets' => array_map(function ($v) {
                return $this->getPetsAllowedLabels($v);
            }, $this->pets_allowed_list),
            'allowed_pets_codes' => array_map(function ($v) {
                return strtr($v, [
                    self::PETS_ALLOWED_CATS => 'cats',
                    self::PETS_ALLOWED_DOGS => 'dogs',
                ]);
            }, $this->pets_allowed_list),
            'facilities' => array_map(function ($v) {
                return $this->getFacilitiesLabels($v);
            }, $this->facilities),
            'facilities_codes' => array_map(function ($v) {
                return strtr($v, [
                    self::FACILITIES_BATHROOM => 'bathroom',
                    self::FACILITIES_TV => 'tv',
                    self::FACILITIES_PARKING => 'parking',
                    self::FACILITIES_GARBAGE_CHUTE => 'garbage_chute',
                    self::FACILITIES_PC => 'pc',
                    self::FACILITIES_WARDROBE => 'wardrobe',
                    self::FACILITIES_DINNER_TABLE => 'dinner_table',
                    self::FACILITIES_REFRIGERATOR => 'refrigerator',
                    self::FACILITIES_GAS_STOVE => 'gas_stove',
                    self::FACILITIES_MICROWAVE => 'microwave',
                    self::FACILITIES_WASHER => 'washer',
                    self::FACILITIES_BALCONY => 'balcony',
                    self::FACILITIES_FIREPLACE => 'fireplace',
                    self::FACILITIES_CUPBOARD => 'cupboard',
                    self::FACILITIES_AIR_CONDITIONING => 'air_conditioning',
                    self::FACILITIES_CONCIERGE => 'concierge',
                ]);
            }, $this->facilities),
            'other_facilities' => $this->facilities_other,
            'phone' => $owner->phone,
            'price' => $this->rent_cost_per_month,
            'min_term' => $this->rent_term_undefined ? '' : $this->rent_term,
            'deposit' => $this->rent_pledge,
            'deposit_month' => $this->getDepositInMonth(),
            'images' => array_map(function ($v) {
                return $v->file->getUrl(true);
            }, (array)$this->getImages()->all()),
            'created_at' => date('c', $this->date_created),
            'updated_at' => date('c', $this->date_updated),
            'expires_at' => date('c', $this->date_updated + 2678400),
            'date_created_at' => date('Y-m-d', $this->date_created),
            'date_updated_at' => date('Y-m-d', $this->date_updated),
            'date_expires_at' => date('Y-m-d', $this->date_updated + 2678400),
        ];
    }

    public function getDepositInMonth()
    {
        if ($this->rent_pledge > 0 && $this->rent_cost_per_month > 0) {
            return sprintf('%d', ceil($this->rent_pledge / $this->rent_cost_per_month));
        }
        return '';
    }

    public function validateAdboardsRequirements()
    {
        if (!empty($this->place_add_to)) {
            foreach ($this->place_add_to as $board_id) {
                $board = AdBoard::findOne($board_id);
                if ($board) {
                    $this->validateAdboardRequirements($board);
                }
            }
        }
    }

    protected function validateAdboardRequirements($board)
    {
        $estate = $this->estate;
        foreach ($board->validation as $attribute => $rule) {
            if ($rule == AdBoard::VALIDATION_REQUIRED) {
                if ($attribute == 'metro') {
                    $this->validateMetroNoDict($estate, $board);
                } elseif ($attribute == 'district') {
                    $this->validateDistrictNoDict($estate, $board);
                } elseif (trim($estate->{$attribute}) === '') {
                    $this->addError('place_add_to', sprintf('%s требует указания значения для %s', $board->name,
                        $estate->getAttributeLabel($attribute)));
                }
            } elseif ($rule == AdBoard::VALIDATION_DICT_CIAN) {
                if ($attribute == 'region') {
                    if (trim($estate->{$attribute}) === '') {
                        $this->addError('place_add_to', sprintf('%s требует указания значения для %s', $board->name,
                            $estate->getAttributeLabel($attribute)));
                    } else {
                        $this->validateRegionByCianDict($estate, $board);
                    }
                } elseif ($attribute == 'metro') {
                    $this->validateMetroByCianDict($estate, $board);
                }
            } elseif ($rule == AdBoard::VALIDATION_DICT_AVITO) {
                if ($attribute == 'city') {
                    if (trim($estate->{$attribute}) === '') {
                        $this->addError('place_add_to', sprintf('%s требует указания значения для %s', $board->name,
                            $estate->getAttributeLabel($attribute)));
                    } else {
                        $this->validateCityByAvitoDict($estate, $board);
                    }
                } elseif ($attribute == 'district') {
                    $this->validateDistrictByAvitoDict($estate, $board);
                }
            }
        }
    }

    protected function validateMetroByCianDict($estate, $board)
    {
        if ($estate->city == 'Москва' || $estate->region == 'Москва') {
            if (trim($estate->metro) === '') {
                $this->addError('place_add_to',
                    sprintf('%s требует указания значения для %s', $board->name, $estate->getAttributeLabel('metro')));
                return;
            } else {
                $metro = CianMetro::findOne(['name' => $estate->metro, 'region_id' => 1]);
            }
        } elseif ($estate->city == 'Санкт-Петербург' || $estate->region == 'Санкт-Петербург') {
            if (trim($estate->metro) === '') {
                $this->addError('place_add_to',
                    sprintf('%s требует указания значения для %s', $board->name, $estate->getAttributeLabel('metro')));
                return;
            } else {
                $metro = CianMetro::findOne(['name' => $estate->metro, 'region_id' => 10]);
            }
        } else {
            return;
        }
        if (!$metro) {
            $this->addError('place_add_to',
                sprintf('Неверно указано метро, %s может не принять объявление', $board->name));
        } elseif ($estate->metro_id != $metro->cian_id) {
            $estate->metro_id = $metro->cian_id;
            RealEstate::updateAll(['metro_id' => $metro->cian_id], 'id = ' . intval($estate->id));
        }
    }

    protected function validateMetroNoDict($estate, $board)
    {
        if ($estate->city == 'Москва' || $estate->region == 'Москва') {
            if (trim($estate->metro) === '') {
                $this->addError('place_add_to',
                    sprintf('%s требует указания значения для %s', $board->name, $estate->getAttributeLabel('metro')));
            }
        } elseif ($estate->city == 'Санкт-Петербург' || $estate->region == 'Санкт-Петербург') {
            if (trim($estate->metro) === '') {
                $this->addError('place_add_to',
                    sprintf('%s требует указания значения для %s', $board->name, $estate->getAttributeLabel('metro')));
            }
        }
    }

    protected function validateRegionByCianDict($estate, $board)
    {
        $area = CianArea::findOne(['name' => $estate->region]);
        if (!$area) {
            $this->addError('place_add_to',
                sprintf('Неверно указан регион, %s может не принять объявление', $board->name));
        } elseif ($estate->region_id != $area->cian_id) {
            $estate->region_id = $area->cian_id;
            RealEstate::updateAll(['region_id' => $area->cian_id], 'id = ' . intval($estate->id));
        }
    }

    protected function validateCityByAvitoDict($estate, $board)
    {
        if ($estate->city == 'Москва' || $estate->region == 'Москва' || $estate->city == 'Санкт-Петербург' || $estate->region == 'Санкт-Петербург') {
            return;
        }
        $city = AvitoCity::findOne(['name' => $estate->city]);
        if (!$city) {
            $this->addError('place_add_to',
                sprintf('Неверно указан город, %s может не принять объявление', $board->name));
        }
    }

    protected function validateDistrictByAvitoDict($estate, $board)
    {
        if ($estate->city == 'Москва' || $estate->region == 'Москва' || $estate->city == 'Санкт-Петербург' || $estate->region == 'Санкт-Петербург') {
            return;
        }
        $city = AvitoCity::findOne(['name' => $estate->city]);
        if ($city) {
            if (AvitoDistrict::find()->where(['city_id' => $city->avito_id])->count() > 0) {
                if (trim($estate->district) === '') {
                    $this->addError('place_add_to', sprintf('%s требует указания значения для %s', $board->name,
                        $estate->getAttributeLabel('district')));
                } else {
                    $district = AvitoDistrict::findOne(['name' => $estate->district, 'city_id' => $city->avito_id]);
                    if (!$district) {
                        $this->addError('place_add_to',
                            sprintf('Неверно указан район города, %s может не принять объявление', $board->name));
                    }
                }
            }
        }
    }

    protected function validateDistrictNoDict($estate, $board)
    {
        if ($estate->city == 'Москва' || $estate->region == 'Москва' || $estate->city == 'Санкт-Петербург' || $estate->region == 'Санкт-Петербург') {
            return;
        }
        $city = AvitoCity::findOne(['name' => $estate->city]);
        if ($city) {
            if (AvitoDistrict::find()->where(['city_id' => $city->avito_id])->count() > 0) {
                if (trim($estate->district) === '') {
                    $this->addError('place_add_to', sprintf('%s требует указания значения для %s', $board->name,
                        $estate->getAttributeLabel('district')));
                }
            }
        }
    }

    public function checkBio()
    {
        if ($this->status == self::STATUS_DISABLED) {
            return '<span class="dashboard-info__footer _gray _disabled">На рассмотрении</span>';
        } elseif ($this->check_biographical_information == 1) {
            return '<span class="dashboard-info__footer _gray _warning">Запрошена проверка</span>';
        } elseif ($this->check_biographical_information > 1) {
            return '<span class="dashboard-info__footer _gray _success">Проверка пройдена</span>';
        } else {
            return '<span class="dashboard-info__footer _gray _success">Опубликован</span>';
        }
    }

    public function isPublished($adId,$serviceId){
        $adsPublication = AdPublication::findOne(['ad_id' => $adId, 'board_id' => $serviceId]);
        if($adsPublication==null){
            return false;
        }else{
            return true;
        }
    }
    public function feedFree($model){
        $user = User::findOne(Yii::$app->user->id);
        if($user->feed_free_date==null OR $user->feed_free_date > time('now')){
            AdPublication::deleteAll(['ad_id' => $model->id]);
            if(is_array($model->place_add_to)){
                if($user->feed_free_date==null){
                    $user->feed_free_date = strtotime('+7 day');
                    $user->save(false);
                }
                foreach ($model->place_add_to as $serviceId)
                {
                    $adsPublication = AdPublication::findOne(['ad_id' => $model->id, 'board_id' => $serviceId]);
                    if (!$adsPublication) {
                        $adsPublication = new AdPublication();
                        $adsPublication->ad_id = $model->id;
                        $adsPublication->board_id = $serviceId;
                        $adsPublication->price_code = AdBoard::STD_PRICE;
                        $adsPublication->feed_free_date = $user->feed_free_date;
                        $adsPublication->save(false);
                    }
                }
            }
        }
    }
    public static function sendInfoNewPublication($user,$boards)
    {
        $toboard = '';
        $i = 0;
        foreach ($boards as $board){
            $board = AdBoard::findOne($board);
            if($i==0){
                $toboard = $board->name;
            }else{
                $toboard = $toboard.', '.$board->name;
            }
            $i++;
        }
        Yii::$app->mailer->compose('ads-publication', [
            'user'  => $user,
            'boards' => $toboard,
        ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
            ->setTo($user->email)
            ->setSubject('Вы подтвердили размещение вашего объекта на ' . CommonHelper::data()->getParam('tld',
                    'arenda.ru'))
            ->send();
    }
    public static function sendInfoUnPublication($user,$board)
    {
        $toboard = '';
        $board = AdBoard::findOne($board);
        $toboard .= $board->name;

        Yii::$app->mailer->compose('ads-un-publication', [
            'boards' => $toboard,
        ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
            ->setTo($user->email)
            ->setSubject('Вы сняли ваш объект с публикации на ' . CommonHelper::data()->getParam('tld',
                    'arenda.ru'))
            ->send();
    }
}
