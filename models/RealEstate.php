<?php

namespace app\models;

use app\components\extend\ActiveRecord;
use app\models\query\RealEstateQuery;
use yii\httpclient\Client;
use yii;

/**
 * This is the model class for table "{{%real_estate}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $address
 * @property string $city
 * @property string $street
 * @property integer $total_area
 * @property integer $corps
 * @property integer $building
 * @property integer $flat
 * @property integer $metro_id
 * @property string $cover_image
 * @property string $cadastr_number
 * @property string $registration_law_kind
 * @property string $registration_law_number
 * @property string $registration_law_date
 * @property string $encumbrance
 * @property string $seizure
 * @property integer $dom
 * @property string $third_party_problem
 * @property integer $check_status
 *
 * @property User $user
 * @property RealEstateCadastr $cadastr
 * @property RealEstateOwner[] $owners
 * @property Ads $ad
 */
class RealEstate extends ActiveRecord
{
	public $cover_image_id_input = null;

	const CHECK_STATUS_NOT_RUN = 0;
	const CHECK_STATUS_START = 1;
	const CHECK_STATUS_IN_PROCESS = 2;
	const CHECK_STATUS_SUCCESS = 3;
	const CHECK_STATUS_ERROR = 4;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%real_estate}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class'          => behaviors\common\SaveFilesBehavior::className(),
				'fileAttributes' => ['cover_image'],
			],
		] + parent::behaviors();
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'total_area', 'flat', 'metro_id', 'building', 'dom', 'check_status'], 'integer'],
			[['title', 'address'], 'string', 'max' => 255],
			[['user_id', 'title', 'city', 'street'], 'required', 'except' => 'fileUpload'],
			[['city', 'street', 'region', 'region_id', 'district', 'district_id', 'metro', 'city_id'], 'string'],
			['cover_image_id_input', 'string'],
			['corps', 'string', 'max' => 4],
			[['cover_image'], 'safe'],
			[['cover_image'], 'file', 'skipOnEmpty' => true, 'extensions' => Files::imageExtension(), 'maxFiles' => 1, 'on' => self::SCENARIO_FILE_UPLOAD],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'          => 'ID',
			'user_id'     => 'Пользователь',
			'title'       => 'Название',
			'address'     => 'Город, улица',
			'city'        => 'Город',
			'street'      => 'Улица',
			'total_area'  => 'Общая площадь',
			'corps'       => 'Корпус',
			'building'    => 'Строение',
			'dom'         => 'Дом',
			'flat'        => 'Квартира',
			'metro_id'    => 'Метро',
			'metro'  	  => 'Метро',
			'cover_image' => 'Обложка',
			'region'	  => 'Область',
			'district'	  => 'Район',
            'cadastr_number' => 'Кадастровый номер',
            'registration_law_kind' => 'Вид государственной регистрации права',
            'registration_law_number' => 'Номер государственной регистрации права',
            'registration_law_date' => 'Дата государственной регистрации права',
            'encumbrance' => 'Ограничение прав и обременение объекта недвижимости',
            'seizure' => 'Сведения о наличии решения об изъятии объекта недвижимости для государственных и муниципальных нужд',
            'third_party_problem' => 'Сведения об осуществлении государственной регистрации прав без необходимого в силу закона согласия третьего лица, органа',
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
	 * @return \yii\db\ActiveQuery
	 */
	public function getMetro()
	{
		return $this->hasOne(Metro::className(), ['id' => 'metro_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAd()
	{
		return $this->hasOne(Ads::className(), ['real_estate_id' => 'id']);
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getOwners()
	{
		return $this->hasMany(RealEstateOwner::className(), ['real_estate_id' => 'id']);
	}

    /**
     * @return yii\db\ActiveQuery
     */
	public function getCadastr()
    {
        return $this->hasOne(RealEstateCadastr::className(), ['cadastr_number' => 'cadastr_number']);
    }

    private function getCadastrData()
    {
        $client = new Client();
        return $client->createRequest()->setMethod('post')
            ->setData(['query' => $this->getReestrSearchAddress()])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/cadaster/search')
            ->send()->getData();
    }

    /**
     * @return RealEstateCadastr|array|bool|null
     */
    public function searchCadastr()
    {
        $response = $this->getCadastrData();
        if (!isset($response['found']) ||
	        (isset($response['error']) && !empty($response['error'])) ||
	        !isset($response['objects']) ||
	        empty($response['objects'])
        ) {
            return false;
        }
        $cadastr_number = $response['objects'][0]['CADNOMER'];
        $cadastr = RealEstateCadastr::find()->findByNumber($cadastr_number)->one();
        if (!$cadastr) {
            $cadastr = new RealEstateCadastr();
            $cadastr->cadastr_number = $cadastr_number;
            $cadastr->status = RealEstateCadastr::STATUS_NOT_RUN;
            $cadastr->save();
        }

        return $cadastr;
    }

	/**
	 *
	 * @param array $options
	 * @return type
	 */
	public function renderCover($options = [])
	{
		/* @var $file Files */
		$file = $this->getFile('cover_image');
		return $file->renderImage($options);
	}

	public function getCoverUrl($options = [])
	{
		$file = $this->getFile('cover_image');
		return $file->getImageUrl($options);
	}

	/**
	 * metro stations
	 * @return type
	 */
	public function getAvailableMetroStations()
	{
		return array_merge([0 => 'Нет'], yii\helpers\ArrayHelper::map(Metro::find()->all(), 'id', 'name'));
	}

	/**
	 * get metro name
	 * @return string
	 */
	public function getMetroName()
	{
		if ($metro = $this->getMetro()->one()) {
			return $metro->name;
		}
		return 'Нет';
	}

	/**
	 * get name
	 * @return type
	 */
	public function getName()
	{
		return $this->getFullAddress();
	}

	/**
	 * get name
	 * @return string
	 */
	public function getFullAddress()
	{
		$array = [];

		if ($this->city != '') {
			$array[] = $this->city;
		}

		if ($this->street != '') {
			$array[] = 'улица ' . $this->street;
		}

		if ($this->dom != '') {
			$array[] = 'дом ' . $this->dom;
		}

		if ($this->building != '') {
			$array[] = 'строение ' . $this->building;
		}

		if ($this->corps != '') {
			$array[] = 'корпус ' . $this->corps;
		}

		if ($this->flat != '') {
			$array[] = 'кв. ' . $this->flat;
		}

		return implode(', ', $array);
	}

    public function getReestrSearchAddress()
    {
        $array = [];

        if ($this->city != '') {
            $array[] = $this->city;
        }

        if ($this->street != '') {
            $array[] = $this->street;
        }

        if ($this->dom != '') {
            if ($this->corps != '') {
                $array[] = $this->dom . '/' . $this->corps;
            } else {
                $array[] = $this->dom;
            }
        }

        if ($this->building != '') {
            $array[] = 'строение ' . $this->building;
        }

        if ($this->flat != '') {
            $array[] = 'кв. ' . $this->flat;
        }

        return implode(', ', $array);
    }

	public function getSmallAddress()
	{
		$array = [];

		if ($this->city != '') {
			$array[] = $this->city;
		}

		if ($this->street != '') {
			$array[] = 'улица ' . $this->street;
		}

		if ($this->dom != '') {
			$array[] = 'дом ' . $this->dom;
		}

		if ($this->flat != '') {
			$array[] = 'кв. ' . $this->flat;
		}

		return implode(', ', $array);
	}

	public function getAddressLine()
	{
		$address = $this->street;
		if ($this->dom) {
			$address .= ', д. ' . $this->dom;
		}
		if ($this->corps) {
			$address .= ', к. ' . $this->corps;
		}
		if ($this->building) {
			$address .= ', стр. ' . $this->building;
		}
		return $address;
	}

	/**
	 * @inheritdoc
	 */
	public function beforeDelete()
	{
		$bd = parent::beforeDelete();
		$this->deleteAd();
		return $bd;
}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {

			if ($this->cover_image_id_input !== null && $this->cover_image_id_input != '') {
				$this->cover_image = $this->cover_image_id_input;
			}

			return true;
		}

		return false;
	}

	/**
	 * delete ads (nneded to delete files)
	 */
	public function deleteAd()
	{
		if ($ad = $this->getAd()->one()) {
			$ad->delete();
		}
	}

    /**
     * @inheritdoc
     * @return RealEstateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RealEstateQuery(get_called_class());
    }
}