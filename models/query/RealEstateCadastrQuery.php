<?php

namespace app\models\query;

use app\models\RealEstateCadastr;

/**
 * This is the ActiveQuery class for [[\app\models\RealEstateCadastr]].
 *
 * @see \app\models\RealEstateCadastr
 */
class RealEstateCadastrQuery extends \yii\db\ActiveQuery
{
    public function findByNumber($number)
    {
        return $this->andWhere(['cadastr_number' => $number]);
    }

    public function inProcess()
    {
        return $this->andWhere(['status' => RealEstateCadastr::STATUS_IN_PROCESS]);
    }

    public function paid()
    {
        return $this->andWhere(['status' => RealEstateCadastr::STATUS_PAID]);
    }

    /**
     * @inheritdoc
     * @return \app\models\RealEstateCadastr[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\RealEstateCadastr|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
