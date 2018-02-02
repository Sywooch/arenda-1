<?php
/**
 * Created by PhpStorm.
 * User: Ulugbek
 * Date: 03.03.2017
 * Time: 9:19
 */
namespace app\components\widgets\ProfileManageCenter;

use app\models\Ads;
use app\models\Applications;
use app\models\LeaseContractParticipants;
use app\models\LeaseContracts;
use app\models\RealEstate;
use app\models\UserPassport;
use Yii;

use yii\base\Widget;
use app\models\User;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use app\models\UserCustomerInfo;
use app\models\UserInfo;
use yii\helpers\Json;

class ProfileManageCenter extends Widget
{
    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $user = Yii::$app->user->identity;
        /* @var $user User */
        $view = $user->isCustomer ? User::ROLE_CUSTOMER : User::ROLE_MANAGER . '_' . User::ROLE_LESSOR;
        $info = $user->loadInfo();
        if($user->passport==null){
            $passport = new UserPassport();
        }else{
            $passport = $user->passport;
        }
        $model = $user->hasRole([User::ROLE_MANAGER, User::ROLE_LESSOR]) ? $this->saveManagerProfile($user) : $this->saveCustomerProfile($user);
        if($user->isCustomer):
            $participantsTableName = LeaseContractParticipants::tableName();
            $contract = LeaseContracts::find()
                ->joinWith(['participants','estate'])
                ->where([
                    $participantsTableName . '.signed' => LeaseContractParticipants::STATUS_SIGNED,
                    $participantsTableName . '.user_id' => $user->id
                ])
                ->one();

            $options = [
                'view' => $view,
                'user' => $user,
                'info' => $info,
                'contract' => $contract,
                'apps' => Applications::find()->innerJoinWith(['ad'])->where([Applications::tableName().'.user_id'=>$user->id])->limit(3)->all(),
                'fills'=>self::percentFill(),
                'model' => $model,
                'passport' => $passport,
            ];
        else:
            $options = [
                'view' => $view,
                'user' => $user,
                'info' => $info,
                'realestate' => RealEstate::find()->where(['user_id'=>$user->id])->limit(4)->all(),
                'ads' => Ads::find()->innerJoinWith(['estate'])->where([RealEstate::tableName().'.user_id'=>$user->id])->limit(3)->all(),
                'fills'=>self::percentFill(),
                'model' => $model,
                'passport' => $passport,
            ];
        endif;

        return $this->render('index_'.$view, $options);
    }
    public static function percentFill(){
        $user = Yii::$app->user->identity;
        /* @var $user User */
        $info = $user->loadInfo();
        if($user->passport==null){
            $passport = new UserPassport();
        }else{
            $passport = $user->passport;
        }

        $percent = 0;
        //user
        $lastname = $user->last_name; //10
        if($lastname!=''){
            $percent = $percent + 10;
        }
        $firstname = $user->first_name; //10
        if($firstname!=''){
            $percent = $percent + 10;
        }
        $middlename = $user->middle_name; //5
        if($middlename!=''){
            $percent = $percent + 5;
        }
        $birthday = $user->date_of_birth; //10
        if($birthday!=''){
            $percent = $percent + 10;
        }
        $email = $user->email; //10
        if($email!=''){
            $percent = $percent + 10;
        }
        $phone = $user->phone; //10
        if($phone!=''){
            $percent = $percent + 10;
        }

        //info
        $about = $info->about; //5
        if($about!=''){
            $percent = $percent + 5;
        }
        $photo = $info->photo; //10
        if($photo!=''){
            $percent = $percent + 10;
        }

        $passfillshow = false;
        //passport
        $pass_serial = $passport->serial_nr; //5
        if($pass_serial!=''){
            $percent = $percent + 5;
        }else{
            $passfillshow = true;
        }
        $pass_issuedby = $passport->issued_by; //5
        if($pass_issuedby!=''){
            $percent = $percent + 5;
        }else{
            $passfillshow = true;
        }
        $pass_issueddate = $passport->issued_date; //5
        if($pass_issueddate!=''){
            $percent = $percent + 5;
        }else{
            $passfillshow = true;
        }
        $pass_divcode = $passport->division_code; //5
        if($pass_divcode!=''){
            $percent = $percent + 5;
        }else{
            $passfillshow = true;
        }
        $pass_placebirth = $passport->place_of_birth; //5
        if($pass_placebirth!=''){
            $percent = $percent + 5;
        }
        $pass_placeresidence = $passport->place_of_residence; //5
        if($pass_placeresidence!=''){
            $percent = $percent + 5;
        }else{
            $passfillshow = true;
        }

        //verify
        $pass_verify = $passport->verify;
        $pass_scanpass = $passport->scan_passport;

        if($percent==0){
            $percent = 100;
        }
        return ['percent'=>$percent,'passfillshow'=>$passfillshow];
    }
    /**
     * save customer profile
     * @param User $user
     */
    public function saveCustomerProfile($user)
    {
        if (!$info = $user->customerInfo) {
            $info = new UserCustomerInfo();
            $info->user_id = $user->primaryKey;
        }
        if (Yii::$app->request->isAjax && $data = Yii::$app->request->post('deleteAdditionalData')) {
            if (@$data['type'] == 'deleteDataCompartment' && @$data['compartment'] && @$data['orderNr']) {
                $stattus = $info->deleteDataCompartment($data['compartment'], $data['orderNr']);
                $ar = [
                    'result'  => $stattus ? 'success' : 'error',
                    'message' => $stattus ? 'Данные удалены!' : 'Не удалось удалить данные!',
                ];
                die(Json::encode($ar));
            }
        }
        $this->saveCommonProfile($user, $info);
        return $info;
    }

    /**
     * save manager profile
     * @param User $user
     */
    public function saveManagerProfile($user)
    {
        if (!$info = $user->info) {
            $info = new UserInfo();
            $info->user_id = $user->primaryKey;
            $info->page_link = $user->username;
        }
        $this->saveCommonProfile($user, $info);
        return $info;
    }

    /**
     * save users info
     * @param User $user
     * @param mixed $info
     */
    public function saveCommonProfile($user, $info)
    {
        $post = Yii::$app->request->post();
        if(isset($post['only_file']) && $info->load($post)){
            if ($info->save()) {
                Yii::$app->getSession()->setFlash('success', 'Данные сохранены ');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Не удалось сохранить данные!<br/>' . CommonHelper::formatModelErrors($info));
            }
           /* $this->redirect(Url::to([
                '/user/profile',
            ]));*/
        } elseif ($info->load($post) && $user->load($post)) {
            $this->ajaxValidation([$user, $info]);
            if ($info->save() && $user->save()) {
                Yii::$app->getSession()->setFlash('success', 'Данные сохранены ');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Не удалось сохранить данные!<br/>' . CommonHelper::formatModelErrors($info));
            }
            /*if ($ad = Yii::$app->request->get('ad')) {
                return $this->redirect(Url::to([
                    '/ads/view', 'id' => (int)$ad, 'c' => 1,
                ]));
            }*/
           /* $this->redirect(Url::to([
                '/user/profile',
            ]));*/
        }

    }
}