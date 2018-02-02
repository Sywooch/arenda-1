<?php

namespace app\models;

use yii;
use app\models\Files;
use app\components\extend\Url;

/**
 * This is the model class for table "{{%user_info}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $page_link
 * @property string $contact_person
 * @property string $company_name
 * @property string $email
 * @property string $phone
 * @property string $site
 * @property string $address
 * @property string $city
 * @property string $street
 * @property string $building
 * @property string $corps
 * @property string $apartment
 * @property string $about
 * @property string $photo
 * @property string $logo
 *
 * @property User $user
 * @method Files getFile(string $attribute) get file
 */
class UserInfo extends \app\components\extend\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_info}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                [
                'class' => behaviors\common\SaveFilesBehavior::className(),
                'fileAttributes' => ['logo', 'photo']
            ]
                ] + parent::behaviors();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['user_id'], 'required'],
                [['user_id'], 'integer'],
                [['page_link', 'site', 'address', 'city', 'street'], 'string'],
                [['photo', 'logo'], 'file', 'skipOnEmpty' => true, 'maxSize' => Files::imageMaxSize(), 'extensions' => Files::imageExtension(), 'maxFiles' => 1],
                [['contact_person', 'company_name', 'email', 'phone', 'building', 'corps', 'apartment', 'about'], 'string', 'max' => 255],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
                [['page_link', 'contact_person', 'company_name', 'email', 'phone', 'site', 'address', 'building', 'city', 'street', 'corps', 'apartment', 'about'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'page_link' => 'Ссылка на страницу',
            'contact_person' => 'Контактное лицо',
            'company_name' => 'Название компании',
            'email' => 'Эл. почта',
            'phone' => 'Номер телефона',
            'site' => 'Ссылка на сайт',
            'address' => 'Адрес',
            'city' => 'Город',
            'street' => 'Улица',
            'building' => 'Дом',
            'corps' => 'Корпус',
            'apartment' => 'Квартира',
            'about' => 'О себе',
            'photo' => 'Ваша фотография',
            'logo' => 'Логотип компании',
        ];
    }

    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);
        $p = new \HTMLPurifier();
        foreach ($this->attributeLabels() as $k => $v) {
            $this->{$k} = $p->purify($this->{$k});
        }
        if (substr($this->site, 0, 4) !== 'http') {
            $this->site = 'http://' . $this->site;
        }
        return $bs;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'photo' => 'Максимальный размер файла 6MB за изображение. JPG, PNG, или только форматы GIF.',
            'logo' => 'Максимальный размер файла 6MB за изображение. JPG, PNG, или только форматы GIF.',
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
     * render photo
     * @param array $options
     * @return img
     */
    public function renderLogo($options = [])
    {
        if (!array_key_exists('alt', $options)) {
            $options['alt'] = $this->company_name;
        }
        if (!array_key_exists('title', $options)) {
            $options['title'] = $this->company_name;
        }
        return $this->getFile('logo')->renderImage($options);
    }

    /**
     * get info page link
     * @return string
     */
    public function getUrl()
    {
        return (!$this->isNewRecord ? Url::to(['/profile/' . $this->page_link]) : 'void:javascript()');
    }

}
