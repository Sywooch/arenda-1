<?php

namespace app\models;

use yii;
use app\models\behaviors\common\SaveFilesBehavior;
use app\components\extend\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%user_customer_info}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $photo
 * @property string $about
 * @property string $data
 * @property string $addational
 *
 * @property User $user
 * @method Files getFile(string $attribute) get file
 */
class UserCustomerInfo extends ActiveRecord
{
    public $addationals;

    const DATA_ADDITIONAL_FIRST_NAME = '[c-data-fn]';
    const DATA_ADDITIONAL_LAST_NAME = '[c-data-ln]';
    const DATA_ADDITIONAL_PHONE = '[c-data-phone]';
    const DATA_ADDITIONAL_EMAIL = '[c-data-email]';
    const DATA_ADDITIONAL_IS_TO_ME = '[c-data-istome]';
    const DATA_EMPL_HISTORY_JOB = '[empl][1][c-data-ehj]';
    const DATA_EMPL_HISTORY_POST = '[empl][1][c-data-ehz]';
    const DATA_EMPL_HISTORY_PERIOD_BGN = '[empl][1][c-data-ehpb]';
    const DATA_EMPL_HISTORY_PERIOD_END = '[empl][1][c-data-ehpe]';
    const DATA_EMPL_HISTORY_EMPLOYER_INFO = '[empl][1][c-data-ehei]';
    const DATA_INCOME_ADDITIONAL = '[income][1][c-data-ia]';
    const DATA_INCOME_ADDITIONAL_SUM = '[income][1][c-data-ias]';
    const DATA_RENT_HISTORY_COUNTRY_CITY = '[rent][1][c-data-rhcc]';
    const DATA_RENT_HISTORY_STREET_HOUSE = '[rent][1][c-data-rhsh]';
    const DATA_RENT_HISTORY_PERIOD_BGN = '[rent][1][c-data-rhpb]';
    const DATA_RENT_HISTORY_PERIOD_END = '[rent][1][c-data-rhpe]';
    const DATA_RENT_HISTORY_PRICE = '[rent][1][c-data-rhp]';
    const DATA_RECOMMEND_FIRST_N = '[recommend][1][c-data-rfn]';
    const DATA_RECOMMEND_LAST_N = '[recommend][1][c-data-rfl]';
    const DATA_RECOMMEND_PHONE = '[recommend][1][c-data-rp]';
    const DATA_RECOMMEND_EMAIL = '[recommend][1][c-data-re]';
    const DATA_RECOMMEND_RELATION = '[recommend][1][c-data-rr]';
    const DATA_SCREENING_WERE_INSOLVENT = '[screening][c-data-swi]';
    const DATA_SCREENING_WERE_CONFLICT = '[screening][c-data-swc]';
    const DATA_SCREENING_WERE_CONFLICT_INFO = '[screening][c-data-swci]';
    const DATA_SCREENING_REFUSED_TO_PAY = '[screening][c-data-srtp]';
    const DATA_SCREENING_CONVICTED = '[screening][c-data-sc]';

    /**
     * data labels
     * @param type $data
     * @return type
     */
    public function getDataLabels($data = null)
    {
        $ar = [
            self::DATA_ADDITIONAL_FIRST_NAME => 'Имя',
            self::DATA_ADDITIONAL_LAST_NAME => 'Фамилия',
            self::DATA_ADDITIONAL_PHONE => 'Телефон',
            self::DATA_ADDITIONAL_EMAIL => 'Email',
            self::DATA_ADDITIONAL_IS_TO_ME => 'Кем приходится',
            self::DATA_EMPL_HISTORY_JOB => 'Место работы',
            self::DATA_EMPL_HISTORY_POST => 'Должность',
            self::DATA_EMPL_HISTORY_PERIOD_BGN => 'Начало работы',
            self::DATA_EMPL_HISTORY_PERIOD_END => 'Конец работы',
            self::DATA_EMPL_HISTORY_EMPLOYER_INFO => 'Информация о работодателе',
            self::DATA_INCOME_ADDITIONAL => 'Дополнительный источник дохода',
            self::DATA_INCOME_ADDITIONAL_SUM => 'Заработок в месяц',
            self::DATA_RENT_HISTORY_COUNTRY_CITY => 'Страна, город',
            self::DATA_RENT_HISTORY_STREET_HOUSE => 'Улица, дом',
            self::DATA_RENT_HISTORY_PERIOD_BGN => 'Период проживания',
            self::DATA_RENT_HISTORY_PERIOD_END => 'Период проживания',
            self::DATA_RENT_HISTORY_PRICE => 'Арендная плата',
            self::DATA_RECOMMEND_FIRST_N => 'Имя',
            self::DATA_RECOMMEND_LAST_N => 'Фамилия',
            self::DATA_RECOMMEND_PHONE => 'Телефон',
            self::DATA_RECOMMEND_EMAIL => 'Email',
            self::DATA_RECOMMEND_RELATION => 'Отношения',
            self::DATA_SCREENING_WERE_INSOLVENT => 'Вы подали заявление о банкротстве?',
            self::DATA_SCREENING_WERE_CONFLICT => 'Были ли у вас конфликты с арендодателями, доходивщего до судебного процеса?',
            self::DATA_SCREENING_WERE_CONFLICT_INFO => 'Были ли у вас конфликты с арендодателями, доходивщего до судебного процеса?',
            self::DATA_SCREENING_REFUSED_TO_PAY => 'Вы умышленно и намеренно отказались платить арендную плату?',
            self::DATA_SCREENING_CONVICTED => 'Вы когда-нибудь были осуждены за преступление или проступок, кроме нарушения движения или стоянки?',
        ];
        if ($data) {
            if (!array_key_exists($data, $ar)) {
                $result = '';
                array_filter($ar, function($key) use ($data, $ar, &$result) {
                    if ((strpos($key, $data) !== false)) {
                        $result = $ar[$key];
                    }
                }, ARRAY_FILTER_USE_KEY);
                return $result;
            }
            return $ar[$data];
        }
        return $ar;
    }

    /**
     * 
     * @param type $relation
     * @return mixed
     */
    public function getDataRecomandationRelationLabels($relation = false)
    {
        $ar = [
            1 => 'Дружеские',
            2 => 'Не дружеские',
        ];

        return $relation ? $ar[$relation] : $ar;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_customer_info}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                'class' => SaveFilesBehavior::className(),
                'fileAttributes' => ['photo']
            ]
                ] + parent::behaviors();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['user_id'], 'integer'],
                [['about'], 'string'],
                [['photo'], 'file', 'skipOnEmpty' => true, 'maxSize' => Files::imageMaxSize(), 'extensions' => Files::imageExtension(), 'maxFiles' => 1],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
                [['data','addational','addationals'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Тип',
            'photo' => 'Ваше фото',
            'about' => 'О себе',
            'data' => 'Доп. Данные',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * render photo
     * @param array $options
     * @return img
     */
    public function renderPhoto($options = [])
    {
	    if ($this->user != null) {
		    if (!array_key_exists('alt', $options)) {
			    $options['alt'] = $this->user->fullName;
		    }
		    if (!array_key_exists('title', $options)) {
			    $options['title'] = $this->user->fullName;
		    }
	    }
	    
        return $this->getFile('photo')->renderImage($options);
    }

	public function getPhotoUrl($options = [])
	{
		return $this->getFile('photo')->getImageUrl($options);
	}

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);
        $this->data = Json::encode($this->data);
        $this->addational = Json::encode($this->addationals);
        return $bs;
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $af = parent::afterFind();
	    $this->data = Json::decode($this->data);
        $this->addational = Json::decode($this->addational);
        return $af;
    }

    /**
     * get data value by constants
     * @param string $constant
     * @param boolean $getAllValuesOfThisType get all values of type that belong to current constant, default false 
     * @return type
     */
    public function getDataValue($constant, $getAllValuesOfThisType = false)
    {
        $v = null;
        $tmp = $this->data;
        foreach (explode(']', $constant) as $k => $attr) {
            if ($attr != null) {
                $key = str_replace('[', '', $attr);
                $v = @$tmp{$key};
                $tmp = @$tmp{$key};
            }
            if ($getAllValuesOfThisType) {
                return is_array($v) ? $v : [];
            }
        }
        return $v;
    }

    /**
     * get date from data
     * @param type $constant
     * @param type $format
     * @return type
     */
    public function getDataDate($constant, $format = 'medium')
    {
        return $this->getDataValue($constant);
    }

    public function deleteDataCompartment($compartment, $orderNr)
    {
        $data = $this->data;
        try {
            unset($data[$compartment][$orderNr]);
        } catch (\Exception $ex) {
            return false;
        }
        $this->data = $data;
        return $this->save();
    }

    /**
     * get additional contact full name
     * @return string
     */
    public function getAdditionalContactFullName()
    {
        $fn = $this->getDataValue(self::DATA_ADDITIONAL_FIRST_NAME);
        $ln = $this->getDataValue(self::DATA_ADDITIONAL_LAST_NAME);
        return $fn . ' ' . $ln;
    }

}
