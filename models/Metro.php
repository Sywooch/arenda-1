<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%metro}}".
 *
 * @property integer $id
 * @property string $name
 */
class Metro extends \app\components\extend\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metro}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }
}
