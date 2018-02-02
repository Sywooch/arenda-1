<?php

use yii\db\Migration;
use yii\rbac\DbManager;
use app\models\User;
use yii\base\UserException;

class m160825_080137_user_roles_create extends Migration
{
    public function up()
    {
        if ($user = User::find()->where(['username' => 'admin'])->one()) {

            $r = new DbManager;
            $r->init();

            $role = $r->createRole("admin", "Administrator");
            $r->add($role);
            $r->assign($role, $user->primaryKey);

            $role = $r->createRole("lessor", "Lessor");
            $r->add($role);
            $r->assign($role, $user->primaryKey);
            
            $role = $r->createRole("manager", "Manager");
            $r->add($role);
            $r->assign($role, $user->primaryKey);

            $role = $r->createRole("customer", "Customer");
            $r->add($role);
            $r->assign($role, $user->primaryKey);
        } else {
            echo "\n\n\n ADMIN USER NOT FOUND! \n\n\n";
            return false;
        }
    }

    public function down()
    {
        return true;
    }

}