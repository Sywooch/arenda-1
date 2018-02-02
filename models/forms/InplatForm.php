<?php
/**
 * Created by PhpStorm.
 * User: ivphpan
 * Date: 18.03.17
 * Time: 12:51
 */

namespace app\models\forms;


use app\models\Pay;
use yii\base\Model;

class InplatForm extends Model
{
    public $method;
    public $pay_type;
    public $status;
    public $code;
    public $params;

    public function rules()
    {
        return [
            ['method', 'compare', 'compareValue' => 'result', 'message' => 'Неверный метод'],
            ['pay_type', 'in', 'range' => ['mc', 'card'], 'message' => 'Неверный идентефикатор формы оплаты'],
            ['status', 'in', 'range' => ['auth', 'cancel']],
            ['code', 'compare', 'compareValue' => 0, 'message' => 'Ошибка при оплате'],
            ['params', 'checkParams'],
        ];
    }

    public function checkParams($attr)
    {
        if (!array_key_exists('id', $this->params)) {
            $this->addError($attr, 'Не указан номер оплаты');
        } elseif (!array_key_exists('sum', $this->params)) {
            $this->addError($attr, 'Не указана сумма');
        }

        $pay = Pay::findOne(['id' => $this->params['id']]);

        if (!$pay) {
            $this->addError($attr, 'Неверный номер оплаты');
        } elseif ($pay->sum != ($this->params['sum'] / 100)) {
            $this->addError($attr, 'Неверная сумма оплаты');
        }

        if($pay->statusPaid()){
            $this->addError($attr,'Данная оплата уже проведена!');
        }
    }

    public function result()
    {
        if (!$this->validate()) {
            return false;
        }
        $pay = Pay::findOne($this->params['id']);
        return $pay->paid();
    }
}