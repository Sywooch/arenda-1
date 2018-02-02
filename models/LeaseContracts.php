<?php

namespace app\models;

use app\components\helpers\CommonHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%lease_contracts}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $real_estate_id
 * @property string $price_per_month
 * @property integer $payment_date
 * @property integer $date_created
 * @property integer $date_begin
 * @property integer $lease_term
 * @property integer $payment_method_id
 * @property integer $status
 * @property integer $deposit_needed
 * @property integer $deposit_sum
 * @property integer $deposit_date_payed
 * @property integer $bills_payed_by
 * @property integer $bills_payed_percent
 * @property integer $facilities
 * @property integer $facilities_other
 * @property string $json
 * @property integer $date_disable
 *
 * @property RealEstate $estate
 */
class LeaseContracts extends \app\components\extend\ActiveRecord
{
    const SCENARIO_STEP_1 = 'step_1';
    const SCENARIO_STEP_2 = 'step_2';
    const SCENARIO_STEP_3 = 'step_3';
    const SCENARIO_STEP_4 = 'step_4';
    const SCENARIO_STEP_5 = 'step_5';
    const SCENARIO_SIGN = 'sign';
    const SCENARIO_CHECK_CODE = 'code';

    const STEPS_COUNT = 5;

    const STATUS_DRAFT = 1;
    const STATUS_NEW = 2;
    const STATUS_SIGNED_BY_OWNER = 4;
    const STATUS_ACTIVE = 3;
    const STATUS_IN_DISABLE = 9;
    const STATUS_DISABLED = 10;
    const STATUS_CANCELED = 20;

    const SESSION_SMS_CONTRACT_SIGN_KEY = 'contract_code';

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

    public $facilities2;

    public $signed = false;
    public $code = false;

    public $additional_bills;

    public $counter_water_hot;
    public $counter_water_cold;
    public $counter_electric_t1;
    public $counter_electric_t2;
    public $counter_electric_t3;
    public $counter_additional;

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

        return $place !== false ? $ar[$place] : $ar;
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

        return $place !== false ? $ar[$place] : $ar;
    }

    public static function getStatusLabels($status = false)
    {
        $ar = [
	        self::STATUS_DRAFT           => 'Новый',
	        self::STATUS_NEW             => 'Черновик',
	        self::STATUS_SIGNED_BY_OWNER => 'Подписан собственником',
	        self::STATUS_ACTIVE          => 'Подписан обеими сторонами',
	        self::STATUS_IN_DISABLE      => 'Договор будет расторгнут',
	        self::STATUS_DISABLED        => 'Договор расторгнут',
	        self::STATUS_CANCELED        => 'Отменён',
        ];

        return $status !== false ? $ar[$status] : $ar;
    }

    public static function getLeaseTermLabels($term = false)
    {
        $ar = [
            11 => '11 Месяцев',
            10 => '10 Месяцев',
            9  => '9 Месяцев',
            8  => '8 Месяцев',
        ];

        return $term !== false ? $ar[$term] : $ar;
    }

    public static function getPaymentDayLabels($day = false)
    {
        $ar = [
            1 => '1 числа',
            2 => '2 числа',
            3 => '3 числа',
            4 => '4 числа',
            5 => '5 числа',
            6 => '6 числа',
            7 => '7 числа',
            8 => '8 числа',
            9 => '9 числа',
            10 => '10 числа',
            11 => '11 числа',
            12 => '12 числа',
            13 => '13 числа',
            14 => '14 числа',
            15 => '15 числа',
            16 => '16 числа',
            17 => '17 числа',
            18 => '18 числа',
            19 => '19 числа',
            20 => '20 числа',
            21 => '21 числа',
            22 => '22 числа',
            23 => '23 числа',
            24 => '24 числа',
            25 => '25 числа',
            26 => '26 числа',
            27 => '27 числа',
            28 => '28 числа',
            29 => '29 числа',
            30 => '30 числа',
            31 => '31 числа',
        ];

        return $day !== false ? $ar[$day] : $ar;
    }

    public static function getBillsPayedByLabels($by = false)
    {
        $ar = [
            1 => 'Оплачивается жильцами',
            2 => 'Оплачивается арендодателем',
            3 => 'Частичная оплата жильцами',
        ];

        return $by !== false ? $ar[$by] : $ar;
    }

    /**
     * @param array $userIds
     *
     * @return ActiveQuery
     */
    public static function findByParts($userIds)
    {
        $query = self::find();
        $query->joinWith(['participants'], true, 'LEFT JOIN');
        $query->orWhere([
            'in',
            self::tableName() . '.user_id',
            $userIds,
        ]);
        $query->orWhere([
            'in',
            User::tableName() . '.id',
            (array)$userIds,
        ]);

        return $query;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lease_contracts}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                   [
                       'class'              => TimestampBehavior::className(),
                       'createdAtAttribute' => 'date_created',
                       'updatedAtAttribute' => null,
                   ],
               ] + parent::behaviors();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['real_estate_id', 'date_begin', 'lease_term', 'payment_date', 'participants', 'price_per_month', 'cancellation_term'],
                'required'
            ],
            ['payment_method_id', 'required', 'message' => 'Необходимо выбрать способ оплаты'],
            [
                'payment_method_id',
                'exist',
                'targetClass'     => '\app\models\PaymentMethods',
                'targetAttribute' => 'id',
                'filter'          => [
                    'user_id' => Yii::$app->user->id,
                    'status'  => PaymentMethods::STATUS_ACTIVE,
                ],
                'message'         => 'Выбранный способ оплаты отсутствует либо отключён',
            ],

            [['real_estate_id', 'payment_date', 'date_created', 'user_id', 'status'], 'integer'],
            [['deposit_needed', 'deposit_date_payed'], 'integer'],
            [
                ['deposit_sum', 'deposit_date_payed'],
                'required',
                'when' => function ($model) {
                    return $this->deposit_needed == 1;
                }
            ],
            [['deposit_sum'], 'number', 'min' => 0],
            [['bills_payed_by'], 'integer'],
            [['bills_payed_percent'], 'integer', 'min' => 0],
            [['payment_date'], 'integer', 'max' => 31, 'min' => 1],
            [['price_per_month'], 'number', 'min' => 0],
            [['cancellation_term'], 'number', 'min' => 30],
            [['cancellation_term'], 'default', 'value' => 30],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['user_id'], 'default', 'value' => (! Yii::$app->user->isGuest ? Yii::$app->user->id : null)],
            ['code', 'required', 'message' => 'Неверный код'],
            [
                'code',
                'compare',
                'compareValue' => Yii::$app->session->get(self::SESSION_SMS_CONTRACT_SIGN_KEY),
                'skipOnEmpty'  => false,
                'message'      => 'Неверный код'
            ],
            ['signed', 'boolean'],
            [
                'signed',
                'required',
                'requiredValue' => 1,
                'message'       => 'Вы должны подтвердить что вы согласны с условиями договора'
            ],
            ['signed_fio', 'required'],
            ['signed_fio', 'validateName'],
            ['signed_fio', 'string', 'max' => 250],
            ['signed_fio', 'trim'],

	        // Счётчики
	        [[
		        'counter_water_hot',
		        'counter_water_cold',
		        'counter_electric_t1',
		        'counter_electric_t2',
		        'counter_electric_t3',
	        ], 'integer', 'min' => 0],
	        ['counter_additional', 'string', 'max' => 250],

            [['facilities_other', 'facilities', 'facilities2', 'additional_bills', 'json', 'date_disable'], 'safe'],
        ];
    }

    public function scenarios()
    {
        $parentScenarios = parent::scenarios();

        $step_1 = ['real_estate_id', 'user_id', 'date_begin', 'lease_term', 'facilities_other', 'facilities', 'facilities2'];
        $step_2 = [
            'price_per_month',
            'payment_date',
            'deposit_needed',
            'deposit_sum',
            'deposit_date_payed',
            'bills_payed_by',
            'bills_payed_percent',
            'cancellation_term',
            'additional_bills',
        ];
        $step_3 = ['user_id', 'payment_method_id'];
        $step_4 = [
        	'counter_water_hot',
	        'counter_water_cold',
	        'counter_electric_t1',
	        'counter_electric_t2',
	        'counter_electric_t3',
	        'counter_additional',
        ];
        //$step_5 = ['confirmed', 'signed_fio', 'code'];

        return [
	        self::SCENARIO_DEFAULT   => $parentScenarios[self::SCENARIO_DEFAULT],
	        self::SCENARIO_STEP_1    => $step_1,
	        self::SCENARIO_STEP_2    => array_merge($step_1, $step_2),
	        self::SCENARIO_STEP_3    => array_merge($step_1, $step_2, $step_3),
	        self::SCENARIO_STEP_4    => array_merge($step_1, $step_2, $step_3, $step_4),
	        self::SCENARIO_STEP_5    => array_merge($step_1, $step_2, $step_3, $step_4),
	        self::SCENARIO_SIGN      => ['signed', 'signed_fio', 'code'],
	        self::SCENARIO_CHECK_CODE => ['code'],
        ];
    }

    public function validateName($attribute, $params)
    {
        if ( ! preg_match('/^[\p{Cyrillic}\s]+$/u', $this->$attribute)) {
            $this->addError($attribute, 'ФИО может содержать только латинские буквы');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
	        'id'                  => 'Nr.',
	        'user_id'             => 'Пользователь',
	        'real_estate_id'      => 'Объект договора',
	        'price_per_month'     => 'Цена за месяц',
	        'payment_date'        => 'Какого числа в месяц вы хотите получать оплату',
	        'date_created'        => 'Дата создания',
	        'date_begin'          => 'Дата начала аренды',
	        'lease_term'          => 'Срок аренды',
	        'payment_method_id'   => 'Способ оплаты',
	        'status'              => 'Статус',
	        'participants'        => 'Участники',
	        'deposit_needed'      => 'Депозит',
	        'deposit_sum'         => 'Сумма депозита',
	        'deposit_date_payed'  => 'Дата оплаты депозита',
	        'bills_payed_by'      => 'Коммунальные услуги',
	        'bills_payed_percent' => 'Проценты оплаты жильцом (ами)',
	        'signed'              => 'Согласие',
	        'signed_fio'          => 'ФИО',
	        'code'                => 'Введите код',
	        'cancellation_term'   => 'Срок уведомления о расторжении договора',
	        'facilities'          => 'Удобства',
	        'facilities2'         => 'Мебель и техника',
	        'facilities_other'    => 'Другие удобства',
	        'counter_water_hot'   => 'Холодная вода',
	        'counter_water_cold'  => 'Горячая вода',
	        'counter_electric_t1' => 'Электроэнергия Т1',
	        'counter_electric_t2' => 'Электроэнергия Т2',
	        'counter_electric_t3' => 'Электроэнергия Т3',
	        'counter_additional'  => 'Дополнительные сведения',
            'date_disable'        => 'Дата расторгнут'
        ];
    }

    public function beforeValidate()
    {
        $this->convertDateToUnix();
        $this->convertPrices();

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    /**
     * convert date from string to unix time
     */
    public function convertDateToUnix()
    {
        if ( ! is_numeric($this->date_begin) && $this->date_begin != '') {
            $this->date_begin = strtotime($this->date_begin);
        }

        if ( ! is_numeric($this->deposit_date_payed) && $this->deposit_date_payed != '') {
            $this->deposit_date_payed = strtotime($this->deposit_date_payed);
        }
    }

    private function convertPrices()
    {
        $this->price_per_month = str_replace(' ', '', $this->price_per_month);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (isset($changedAttributes['status']) && $this->status == self::STATUS_NEW) {
            $this->sendContractMessages();
        }
    }

    public function sendContractMessages()
    {
	    foreach ($this->participants as $participant) {
		    $user = $participant->user;
		    if ($user != null) {
			    if ($user->status == User::STATUS_DISABLED) {
				    $user->status = User::STATUS_ACTIVE;
				    $password = Yii::$app->security->generateRandomString(6);
				    $user->password = $password;

				    if ($user->save()) {
					    $user->assignRole(User::ROLE_CUSTOMER, $user->getRoleLabels());

					    Yii::$app->mailer->compose('sign-up-contract', [
						    'user'     => $user,
						    'password' => $password,
						    'contract' => $this,
					    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
						    ->setTo($user->email)
						    ->setSubject('Вы были добавлены как участник Договора на ' . CommonHelper::data()->getParam('tld',
								    'arenda.ru'))
						    ->send();
				    }
			    } else {
				    Yii::$app->mailer->compose('contract-added', [
					    'user'     => $user,
					    'contract' => $this,
				    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
					    ->setTo($user->email)
					    ->setSubject('Вы были добавлены как участник Договора на ' . CommonHelper::data()->getParam('tld',
							    'arenda.ru'))
					    ->send();
			    }
		    }
	    }
    }

    public function isSignedByUser($user_id)
    {
    	if  ($this->user_id == $user_id) {
    		// если проверяем относительно хозяина контракта

    		$ownerSignedStatuses = [
			    self::STATUS_SIGNED_BY_OWNER,
			    self::STATUS_ACTIVE,
		    ];

		    return (in_array($this->status, $ownerSignedStatuses) && !empty($this->signed_fio));

	    } elseif($user_id==null){
            return $this->getParticipants()->where([
                //'user_id' => $user_id,
                'signed'  => LeaseContractParticipants::STATUS_SIGNED,
            ])->exists();
        } else {
		    return $this->getParticipants()->where([
			    'user_id' => $user_id,
			    'signed'  => LeaseContractParticipants::STATUS_SIGNED,
		    ])->exists();
	    }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(LeaseContractParticipants::className(), ['lease_contract_id' => 'id'])->indexBy('id');
    }
    public function getEstates()
    {
        return $this->hasMany(RealEstate::className(), ['real_estate_id' => 'id'])->indexBy('id');
    }

    public function getFirstParticipant() {
        return $this->hasOne(LeaseContractParticipants::className(), ['lease_contract_id' => 'id']);
    }

    public function tryActivate()
    {
	    $has_participant = LeaseContractParticipants::find()->where(['lease_contract_id' => $this->id])->exists();
        $has_unsigned = LeaseContractParticipants::find()->where(['lease_contract_id' => $this->id, 'signed' => 0])->all();

        //if ($this->status == self::STATUS_SIGNED_BY_OWNER && $has_participant && !$has_unsigned) {
            $this->status = self::STATUS_ACTIVE;

            if ($this->save()) {
                // Ура! Договор подписан всеми и активирован!
                return true;
            }
        //}

        return false;
    }

    /*public function getParticipants()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable(LeaseContractParticipants::tableName(), ['lease_contract_id' => 'id'])->indexBy('id');
    }*/

    public function getParticipant()
    {
        return $this->hasOne(LeaseContractParticipants::className(), ['lease_contract_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstate()
    {
        return $this->hasOne(RealEstate::className(), ['id' => 'real_estate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	public function getPaymentMethod()
	{
		return $this->hasOne(PaymentMethods::className(), ['id' => 'payment_method_id']);
	}

    public function getPricePerMonth()
    {
        return CommonHelper::getPrice($this->price_per_month) . ' в месяц';
    }

    public function getPricePerYear()
    {
        return CommonHelper::getPrice($this->price_per_month * 12) . ' в год';
    }

    public function getDepositSum()
    {
        return CommonHelper::getPrice($this->deposit_sum);
    }

    /**
     * get contract title
     * @return string
     */
    public function getTitle()
    {
        return $this->estate->getName();
    }

    /**
     *
     * @param type $user_id
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistory($user_id)
    {
        $query = Notifications::find();
        $query->where("data->>'lease_contract_id'=:cid AND user_id=:uid", [
            'cid' => $this->primaryKey,
            'uid' => (int)$user_id > 0 ? (int)$user_id : Yii::$app->user->id,
        ]);

        return $query;
    }

    /**
     * Сообшения для расторгунть договор
     *
     */
    public function sendContractInDisableMessage($userId=null)
    {
        $userSender = User::findOne(Yii::$app->user->id);

        if($userId!=null){ //Собственнику
            $toRas = User::findOne($userId);
            if($toRas!=null AND !empty($toRas->email)){
                Yii::$app->mailer->compose('contract-in-disable-part', [
                    'rasUser'     => $userSender->getFullNameAll(),
                    'dogId' => $this->id,
                    'isOwner' => true,
                ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                    ->setTo($toRas->email)
                    ->setSubject('Уведомление о намерении расторжения договора №'.$this->id)
                    ->send();
            }
        }else{ //Нанимателю
            foreach ($this->participants as $participant) {
                $user = $participant->user;
                if($user!=null AND !empty($user->email) AND $participant->signed == 1){
                    Yii::$app->mailer->compose('contract-in-disable-owner', [
                        'rasUser'     => $userSender->getFullNameAll(),
                        'dogId' => $this->id,
                        'isOwner' => false,
                    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                        ->setTo($user->email)
                        ->setSubject('Уведомление о намерении расторжения договора №'.$this->id)
                        ->send();
                }
            }
        }
        
    }

    /**
     * Сообшения для расторгунть договор
     *
     */
    public function sendContractDisableMessage($userId=null)
    {
        if($userId!=null) {
            $fromRas = User::findOne($userId);
            $user = $this->user;
            if ($user != null AND !empty($user->email)) {
                Yii::$app->mailer->compose('contract-disable', [
                    'rasUser' => $fromRas->getFullNameAll(),
                    'dogId' => $this->id,
                ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                    ->setTo($user->email)
                    ->setSubject('Ваш договор №' . $this->id . ' расторгнут на ' . CommonHelper::data()->getParam('tld',
                            'arenda.ru'))
                    ->send();
            }
        }else{
            foreach ($this->participants as $participant) {
                $user = $participant->user;
                if ($user != null AND !empty($user->email) AND $participant->signed == 1) {
                    Yii::$app->mailer->compose('contract-disable', [
                        'rasUser' => $this->user->getFullNameAll(),
                        'dogId' => $this->id,
                    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                        ->setTo($user->email)
                        ->setSubject('Ваш договор №' . $this->id . ' расторгнут на ' . CommonHelper::data()->getParam('tld',
                                'arenda.ru'))
                        ->send();
                }
            }
        }
    }
    public function sendContractDisableMessageParts()
    {
        foreach ($this->participants as $participant) {
            $user = $participant->user;
            if ($user != null AND !empty($user->email) AND $participant->signed == 1) {
                Yii::$app->mailer->compose('contract-disable', [
                    'rasUser' => $this->user->getFullNameAll(),
                    'dogId' => $this->id,
                ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                    ->setTo($user->email)
                    ->setSubject('Ваш договор №' . $this->id . ' расторгнут на ' . CommonHelper::data()->getParam('tld',
                            'arenda.ru'))
                    ->send();
            }
        }
    }    

    /**
     * Сообшения для отозвать договор
     *
     */
    public function sendContractCancelMessageParts()
    {
	    foreach ($this->participants as $participant) {
		    $user = $participant->user;

		    if ($user != null AND !empty($user->email)) {
			    Yii::$app->mailer->compose('contract-cancel', [
				    'rasUser'  => $this->user->getFullNameAll(),
				    'contract' => $this,
			    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
				    ->setTo($user->email)
				    ->setSubject('Ваш договор №' . $this->id . ' отозван на ' . CommonHelper::data()->getParam('tld',
						    'arenda.ru'))
				    ->send();
		    }
	    }
    }
    /**
     * Сообшения для отправить договор на переподписания
     *
     */
    public function sendContractResignMessage()
    {
        foreach ($this->participants as $participant) {
            $user = $participant->user;

            if ($user != null AND !empty($user->email)) {
                Yii::$app->mailer->compose('contract-resign', [
                    'rasUser'  => $this->user->getFullNameAll(),
                    'contract' => $this,
                ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                    ->setTo($user->email)
                    ->setSubject('Cобственник внес изменения в договор №' . $this->id . '. Вам нужно подписать его заново на ' . CommonHelper::data()->getParam('tld',
                            'arenda.ru'))
                    ->send();
            }
        }
    }
    /**
    * Check contract for signed in period
    */
    public function checkContract(){
        //Поиск договоры по объекту наличие на подписан
        $participantsTableName = LeaseContractParticipants::tableName();
        $allcontracts = self::find()
            ->alias('t')
            ->joinWith(['participants'])
            ->where([
                't.real_estate_id' => $this->real_estate_id,
            ])
            ->andWhere([
                $participantsTableName . '.signed' => LeaseContractParticipants::STATUS_SIGNED,
            ])
            ->all();
        if($allcontracts!=null){
            foreach ($allcontracts as $contract){
                if(
                	$contract->status==self::STATUS_ACTIVE ||
                	$contract->status==self::STATUS_SIGNED_BY_OWNER ||
	                $contract->status==self::STATUS_NEW
                ){
                    //Дата начало и конец договора.
                    $curr_start = $this->date_begin;
                    $curr_endDate = (strtotime('+' . $this->lease_term . 'month', $this->date_begin));

                    $contract_start = $contract->date_begin;
                    $contract_endDate = (strtotime('+' . $contract->lease_term . 'month', $contract->date_begin));
                    //Проверка на вне дату
                    if(($curr_start<=$contract_start AND $contract_start<=$curr_endDate)
                        OR ($curr_start<=$contract_endDate AND $contract_endDate<=$curr_endDate)){
                        //не возможно подипсать
                        return false;
                    }
                }

            }
        }
        //можно подипсать
        return true;
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

	    if ($this->json != null) {
		    $this->json = json_decode($this->json, true);
	    } else {
		    $this->json = [];
	    }

		$this->additional_bills = ArrayHelper::getValue($this->json, 'additional_bills', '');
		$this->counter_water_hot = ArrayHelper::getValue($this->json, 'counter_water_hot', 0);
		$this->counter_water_cold = ArrayHelper::getValue($this->json, 'counter_water_cold', 0);
		$this->counter_electric_t1 = ArrayHelper::getValue($this->json, 'counter_electric_t1', 0);
		$this->counter_electric_t2 = ArrayHelper::getValue($this->json, 'counter_electric_t2', 0);
		$this->counter_electric_t3 = ArrayHelper::getValue($this->json, 'counter_electric_t3', 0);
		$this->counter_additional = ArrayHelper::getValue($this->json, 'counter_additional', '');

        return $af;
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

	    $this->json = json_encode([
		    'additional_bills'    => $this->additional_bills,
		    'counter_water_hot'   => $this->counter_water_hot,
		    'counter_water_cold'  => $this->counter_water_cold,
		    'counter_electric_t1' => $this->counter_electric_t1,
		    'counter_electric_t2' => $this->counter_electric_t2,
		    'counter_electric_t3' => $this->counter_electric_t3,
		    'counter_additional'  => $this->counter_additional,
	    ]);

	    return $bs;
    }
}
