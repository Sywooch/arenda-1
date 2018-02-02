<?php

namespace app\models\forms;

use yii;
use yii\base\Model as BaseModel;
use app\components\helpers\CommonHelper;
use app\models\User;

/**
 * InviteLessorForm 
 */
class TransactionRasxodForm extends BaseModel
{

    public $name;
    public $date;
    public $summ;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // fio, email, subject and body are required
            [['name', 'date', 'summ'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Назначение платежа',
            'date' => 'Дата оплаты',
            'summ' => 'Размер платежа',
        ];
    }

}
