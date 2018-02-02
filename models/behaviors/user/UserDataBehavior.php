<?php

/**
 * Description of UserDataBehavior
 *
 * @author postolachiserghei
 */

namespace app\models\behaviors\user;

use yii;
use yii\db\BaseActiveRecord;
use app\models\User;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the behavior for data attribute in \app\models\User".
 *
 * @property \app\models\User $owner
 */
class UserDataBehavior extends \yii\base\Behavior
{

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function beforeSave()
    {
        if ($this->owner->hasAttribute('data')) {
            $old = $this->owner->isNewRecord ? [] : Json::decode(@$this->owner->oldAttributes['data']);
            $new = is_array($this->owner->data) ? $this->owner->data : Json::decode($this->owner->data);
            $this->owner->data = Json::encode(ArrayHelper::merge((array) $old, (array) $new));
        }
    }

    public function afterFind()
    {
        if ($this->owner->hasAttribute('data')) {
            $this->owner->data = Json::decode($this->owner->data);
        }
    }

    /**
     * get data labels
     * @param string $data
     * @return mixed
     */
    public function getDataLabels($data = null)
    {
        $ar = [
            User::DATA_NOTE_NEW_APPLICATION => 'Новые заявки',
            User::DATA_NOTE_CHECK_PERSONAL_DATA => 'Проверка личных данных и кредитных отчётов',
            User::DATA_NOTE_STATUS_OF_COSTUMER_CHECK => 'Статус арендатора',
            User::DATA_NOTE_WHEN_CUSTOMER_PAY => 'Статус оплаты',
            User::DATA_NOTE_BEFORE_LEASE_ENDS => 'Напоминание об окончании аренды',
        ];
        return $data ? $ar[$data] : $ar;
    }

    /**
     * get data hints
     * @param string $data
     * @return mixed
     */
    public function getDataHints($data = null)
    {
        $ar = [
            User::DATA_NOTE_NEW_APPLICATION => 'Напишите мне, когда я получаю новые заявки',
            User::DATA_NOTE_CHECK_PERSONAL_DATA => 'Напишите мне, когда я получаю новые отчёты скрининга от заявителей, или когда они отказываются запускать требуемые доклады.',
            User::DATA_NOTE_STATUS_OF_COSTUMER_CHECK => 'Напишите мне, статус проверки моего арендатора за пять дней да арендной платы за первый месяц (только для новых договоров аренды)',
            User::DATA_NOTE_WHEN_CUSTOMER_PAY => 'Напишите мне, когда арендатор проводит платёж. Если у вас есть несколько плательщиков или объектов, мы вышлем Вам сводку всех платежей.',
            User::DATA_NOTE_BEFORE_LEASE_ENDS => 'Отправить мне напоминание за несколько недель до окончания аренды',
        ];
        return $data ? $ar[$data] : $ar;
    }

    /**
     * get data value by constant key
     * @param string $constant User::DATA_{...}
     * @param mixed $alternative
     * @return mixed
     */
    public function getDataByConstant($constant, $alternative = null)
    {
        if ($this->owner->hasAttribute('data') && is_array($this->owner->data)) {
            try {
                $c = str_replace('data[', '', $constant);
                $c = str_replace('][', '.', $c);
                $c = str_replace(']', '', $c);
                return ArrayHelper::getValue($this->owner->data, $c, $alternative);
            } catch (\Exception $ex) {
                return $alternative;
            }
        }
        return $alternative;
    }

}
