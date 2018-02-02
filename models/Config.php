<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property int $agreement_fixed_part_change_notification
 * @property int $agreement_days_to_transfer_object
 * @property int $agreement_days_to_prolongation
 * @property int $agreement_days_to_cancellation
 */
class Config extends ActiveRecord
{
    const SCENARIO_AGREEMENT = 'agreement';
    
    public function scenarios() {
        return [
            self::SCENARIO_AGREEMENT => [
                'agreement_fixed_part_change_notification',
                'agreement_days_to_transfer_object',
                'agreement_days_to_prolongation'
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar_config';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'agreement_fixed_part_change_notification',
                    'agreement_days_to_transfer_object',
                    'agreement_days_to_prolongation'
                ],
                'default',
                'value' => 30
            ],
            [
                [
                    'agreement_fixed_part_change_notification',
                    'agreement_days_to_transfer_object',
                    'agreement_days_to_prolongation'
                ],
                'integer'
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'agreement_fixed_part_change_notification' => 'Срок уведомления об изменении фиксированной части',
            'agreement_days_to_transfer_object' => 'Количество дней для передачи объекта',
            'agreement_days_to_prolongation' => 'Срок уведомления о продлении договора',
        ];
    }
}
