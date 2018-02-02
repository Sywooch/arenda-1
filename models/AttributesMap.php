<?php

namespace app\models;

use yii;

/**
 * This is the model class for table "{{%attributes_map}}".
 *
 * @property integer $id
 * @property string $label
 * @property string $hint
 * @property integer $input_type
 * @property integer $purpose
 * @property integer $parent
 * @property integer $group_with
 * @property string $before
 * @property string $after
 * @property integer $position
 * @property string $label_for_customers
 * @property integer $show_to_customers
 * 
 * @property AdAttributeValues $adValues
 */
class AttributesMap extends \app\components\extend\ActiveRecord
{
    const PURPOSE_AD = 0;
    const INPUT_TYPE_TEXTAREA = 'textArea';
    const INPUT_TYPE_HIDDEN = 'hiddenInput';
    const INPUT_TYPE_TEXT = 'textInput';
    const INPUT_TYPE_CHECKBOX = 'checkBox';
    const INPUT_TYPE_RADIO = 'radio';

    /**
     * @param string/boolean $type
     * @return type
     */
    public function getInputTypesLabels($type = false)
    {
        $ar = [
            self::INPUT_TYPE_TEXT => 'Ткстовое поле',
            self::INPUT_TYPE_TEXTAREA => 'TextArea',
            self::INPUT_TYPE_CHECKBOX => 'Флажок',
            self::INPUT_TYPE_RADIO => 'Переключатель',
            self::INPUT_TYPE_HIDDEN => 'Скрытое поле',
        ];
        return $type !== false ? $ar[$type] : $ar;
    }

    /**
     * @param integer/boolean $purpose
     * @return type
     */
    public function getPurposeToLabels($purpose = false)
    {
        $ar = [
            self::PURPOSE_AD => 'Атрибуты для объявлений',
        ];
        return $purpose !== false ? $ar[$purpose] : $ar;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attributes_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['input_type', 'label'], 'required'],
            [['purpose', 'group_with'], 'default', 'value' => 0],
            [['input_type'], 'default', 'value' => 'textInput'],
            [['label', 'label_for_customers', 'input_type', 'hint', 'before', 'after'], 'string'],
            [['purpose', 'parent', 'show_to_customers'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'label_for_customers' => 'если заполнить то будет выводится в карточке объявления'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Заголовок',
            'hint' => 'Подсказка',
            'input_type' => 'Тип поля',
            'purpose' => 'Purpose',
            'parent' => 'Родитель',
            'before' => 'Вывод перед атрибутом',
            'after' => 'Вывод после атрибута',
            'position' => 'Position',
            'group_with' => 'Состоит в группе',
            'show_to_customers' => 'Показывать клиентам',
            'label_for_customers' => 'Альтернативный заголовок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdValues()
    {
        return $this->hasMany(AdAttributeValues::className(), ['attribute_id' => 'id']);
    }

    /**
     * get all childs of the record
     */
    public function getChilds()
    {
        return self::find()->where(['parent' => $this->primaryKey])->orderBy('position')->all();
    }

    /**
     * get all available parents
     */
    public function getAvailableParents()
    {
        return self::find()->where(['parent' => 0])->orderBy('position')->all();
    }

    /**
     * get all available records to group with (is needed white type input is radio)
     */
    public function getAvailableGroupWith()
    {
        return self::find()->where([
                    'parent' => 0
                ])->orderBy('position')->all();
    }

    /**
     * get group
     */
    public function getGroup()
    {
        return self::find()->where([
                    'id' => $this->group_with
                ])->one();
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $ad = parent::afterDelete();
        self::deleteAll('parent=:p', [
            'p' => $this->primaryKey
        ]);
        self::updateAll(['group_with' => 0], 'group_with=:g', [
            'g' => $this->primaryKey
        ]);
        return $ad;
    }

    public function getLabelWithGroup()
    {
        if ($this->group_with == 0) {
            return $this->label;
        }
        if ($group = $this->getGroup()) {
            return $group->label . ' - ' . $this->label;
        }
        return $this->label;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $bs = parent::beforeSave($insert);
        if ($this->input_type != self::INPUT_TYPE_RADIO) {
            $this->group_with = 0;
        }
        return $bs;
    }

}