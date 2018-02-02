<?php

/**
 * Description of UserInfoBehavior
 *
 * @author postolachiserghei
 */

namespace app\models\behaviors\user;

use yii;
use yii\db\BaseActiveRecord;
use app\models\User;
use app\models\UserInfo;
use app\models\UserCustomerInfo;
use app\models\Notifications;
use app\components\helpers\CommonHelper;

/**
 * This is the behavior for data attribute in \app\models\User".
 *
 * @property \app\models\User $owner
 */
class UserInfoBehavior extends \yii\base\Behavior
{

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            BaseActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    /**
     * check if current user is customer
     * @return type
     */
    public function getIsCustomer()
    {
        return $this->owner->hasRole(User::ROLE_CUSTOMER) ? true : false;
    }

    /**
     * Является ли пользователь собственником
     * @return bool
     */
    public function getIsLessor()
    {
        return $this->owner->hasRole(User::ROLE_LESSOR) ? true : false;
    }

    /**
     * check if current user is manager
     * @return type
     */
    public function getIsManager()
    {
        return $this->owner->hasRole(User::ROLE_MANAGER) ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        return $this->owner->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerInfo()
    {
        return $this->owner->hasOne(UserCustomerInfo::className(), ['user_id' => 'id']);
    }

    /**
     * load info in dependence of user role
     * @return type
     */
    public function loadInfo($d = null)
    {

        if (!$this->owner->isCustomer) {
            $info = $this->owner->info ? $this->owner->info : new UserInfo();
        } else {
            $info = $this->owner->customerInfo ? $this->owner->customerInfo : new UserCustomerInfo();
        }
        return $info;
    }

    public function afterSave()
    {
        $this->generateInfo();
    }

    public function generateInfo()
    {
        $info = $this->loadInfo(true);
        /* @var $info \app\components\extend\ActiveRecord */
        if ($info->isNewRecord) {
            $info->user_id = $this->owner->primaryKey;
            if ($info instanceof UserInfo) {
                $info->page_link = $this->owner->transliterateUserName();
            }
            if ($info->validate()) {
                $info->save();
            } else {
                $info->noteAdminsOfErrors();
            }
        }
    }

}
