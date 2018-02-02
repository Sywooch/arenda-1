<?php

namespace app\models\query;

use app\models\RealEstate;

/**
 * This is the ActiveQuery class for [[\app\models\RealEstate]].
 *
 * @see \app\models\RealEstate
 */
class RealEstateQuery extends \yii\db\ActiveQuery
{
    public function checkStart()
    {
        return $this->andWhere(['check_status' => RealEstate::CHECK_STATUS_START]);
    }

    /**
     * @inheritdoc
     * @return \app\models\RealEstate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\RealEstate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
