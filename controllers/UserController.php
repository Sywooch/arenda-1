<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\extend\Url;
use app\components\helpers\CommonHelper;
use app\components\ScoristaAPI;
use app\models\forms\InviteCustomerForm;
use app\models\forms\InviteLessorForm;
use app\models\forms\UserAddationalContactForm;
use app\models\ScreeningReport;
use app\models\search\RealEstateSearch;
use app\models\User;
use app\models\UserCustomerInfo;
use app\models\UserInfo;
use app\models\UserPassport;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\base\Model;

class UserController extends FrontendCabinetController
{
    public $defaultAction = 'cabinet';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['card', 'profile'],
                        'allow'   => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Displays info params.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->user->loginRequired();
        }
        return $this->render('index');
    }
    
    /**
     * Displays info params.
     *
     * @return string
     */
    public function actionProfile($id = null)
    {
        $inviteLessorForm = new InviteLessorForm();
        $inviteCustomerForm = new InviteCustomerForm();
        if ($id !== null) {
            if (!$user = User::findById($id)) {
                $this->throwNoPageFound();
            }

            if (Yii::$app->user->isGuest || $user->id != Yii::$app->user->id) {
                $this->headerMenuView = 'menu_default';
                $this->pageBaseClass .= ' page-lk page-lk--not-lk page-lord';
            }

        } else {
            if (Yii::$app->user->isGuest) {
                return Yii::$app->user->loginRequired();
            }
            $user = Yii::$app->user->identity;

            if(isset(Yii::$app->request->isPost)){
                $post = Yii::$app->request->post();
                //Из собственника к жилцов
                if(isset($post['InviteCustomerForm'])){
                    $inviteCustomerForm->load($post);
                    $this->ajaxValidation($inviteCustomerForm);
                    if ($inviteCustomerForm->validate()) {
                        if ($inviteCustomerForm->send(['sender' => $user])) {
                            Yii::$app->getSession()->setFlash('success', 'Приглашение отправлено успешно!');
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Не удалось отправить приглашение!');
                        }
                        $inviteCustomerForm = new InviteCustomerForm();
                    }
                }
                //Из жилец к собственников
                if(isset($post['InviteLessorForm'])){
                    $inviteLessorForm->load($post);
                    $this->ajaxValidation($inviteLessorForm);
                    if ($inviteLessorForm->validate()) {
                        if ($inviteLessorForm->send(['sender' => $user])) {
                            Yii::$app->getSession()->setFlash('success', 'Приглашение отправлено успешно!');
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Не удалось отправить приглашение!');
                        }
                        $inviteLessorForm = new InviteLessorForm();
                    }
                }
            }
            //$this->sendInviteToLessor($user, $inviteLessorForm);
            //$this->sendInviteToCustomer($user, $inviteCustomerForm);
        }

        /* @var $user User */
        $view = $user->isCustomer ? User::ROLE_CUSTOMER : User::ROLE_MANAGER . '_' . User::ROLE_LESSOR;
        $info = $user->loadInfo();

        /* @var $user User */
        $model = $user->hasRole([User::ROLE_MANAGER, User::ROLE_LESSOR]) ? $this->saveManagerProfile($user) : $this->saveCustomerProfile($user);
        if(isset($post['only_file'])){
            $this->refresh();
        }
        return $this->render('profile', [
            'view'             => $view,
            'user'             => $user,
            'info'             => $info,
            'inviteLessorForm' => $inviteLessorForm,
            'inviteCustomerForm' => $inviteCustomerForm,
            'realEstate'       => RealEstateSearch::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->all(),
            'model' => $model,
        ]);
    }

    /**
     * send invitation to the lessor
     * @param User $user
     * @param InviteLessorForm $inviteLessorForm
     */
    public function sendInviteToLessor($user, $inviteLessorForm)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $ar = [
                'message' => 'Неизвестная ошибка!',
                'result'  => 'error',
                'post'    => $post,
            ];
            if (@$post['type'] != 'send-invitation') {
                die(Json::encode($ar));
            }
            $inviteLessorForm->attributes = @$post['data'];
            if ($inviteLessorForm->validate()) {
                if ($inviteLessorForm->send(['sender' => $user])) {
                    $ar['message'] = 'Приглашение отправлено успешно!';
                    $ar['result'] = 'success';
                } else {
                    $ar['message'] = 'Не удалось отправить приглашение!';
                    $ar['result'] = 'error';
                }
            } else {
                $ar['message'] = CommonHelper::formatModelErrors($inviteLessorForm);
            }
            die(Json::encode($ar));
        }
    }

    /**
     * send invitation to the customer
     * @param User $user
     * @param InviteCustomerForm $inviteCustomerForm
     */
    public function sendInviteToCustomer($user, $inviteCustomerForm)
    {

        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $ar = [
                'message' => 'Неизвестная ошибка!',
                'result'  => 'error',
                'post'    => $post,
            ];
            if (@$post['type'] != 'send-invitation') {
                die(Json::encode($ar));
            }
            $inviteCustomerForm->attributes = @$post['data'];
            if ($inviteCustomerForm->validate()) {
                if ($inviteCustomerForm->send(['sender' => $user])) {
                    $ar['message'] = 'Приглашение отправлено успешно!';
                    $ar['result'] = 'success';
                } else {
                    $ar['message'] = 'Не удалось отправить приглашение!';
                    $ar['result'] = 'error';
                }
            } else {
                $ar['message'] = CommonHelper::formatModelErrors($inviteCustomerForm);
            }
            die(Json::encode($ar));
        }
    }

    /**
     * Displays info params.
     *
     * @return string
     */
    public function actionProfileUpdate()
    {
        $user = Yii::$app->user->identity;
        /* @var $user User */
        $passport = $user->passport;
        if ($passport == null) {
            $passport = new UserPassport();
            $passport->user_id = Yii::$app->user->id;
        }
        $readonly = $passport->verify==UserPassport::VERIFY_VERIFIED?true:false;
        if(!$readonly AND isset($_GET['deletescan'])){
            if(!empty($passport->scan_passport)){
                $passport->deleteScan();
                $passprt = UserPassport::findOne($passport->id);
                $passprt->scan_passport = '';
                if($passprt->save(false)){
                    Yii::$app->getSession()->setFlash('success', 'Скан паспорт удалён');
                }
            }
            return $this->redirect('profile-update');
        }

        $formData = Yii::$app->request->post();
        if ($user->load($formData)) {

            $validUser = $user->validate();
            $validPassport = true;

            if ($passport->load($formData)) {
                $validPassport = $passport->validate();
            }

            //save scan photo
            $passport2 = $user->passport;
            if ($passport2 == null) {
                $passport2 = new UserPassport();
                $passport2->user_id = Yii::$app->user->id;
            }
            $passport2->scan_passport = $passport->scan_passport;
            $passport2->update(false);

            if (!$readonly AND ($validUser && $validPassport)) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    if ($passport->save()) {
                        $transaction->commit();

                        if(isset($_GET['scrining'])){
                            $this->redirect('/scrining/create?type='.$_GET['scrining']);
                        }

                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        $model = $user->hasRole([User::ROLE_MANAGER, User::ROLE_LESSOR]) ? $this->saveManagerProfile($user) : $this->saveCustomerProfile($user);
        if($user->verify_save==1){
            $this->redirect('verify');
        }
        return $this->render('profile_update', [
            'view'  => (($model instanceof UserCustomerInfo) ? User::ROLE_CUSTOMER : User::ROLE_MANAGER . '_' . User::ROLE_LESSOR) . '_info',
            'user'  => $user,
            'model' => $model,
            'passport' => $passport,
            'readonly' => $readonly,
        ]);
    }

    public function actionValidate(){
        if(isset($_POST)){
            $user = new User(['scenario' => 'update']);
            $passport = new UserPassport(['scenario' => 'update']);
            $formData = Yii::$app->request->post();
            if ($user->load($formData)) {
                $u = ActiveForm::validate($user);
                $passport->user_id = Yii::$app->user->id;
                if( $passport->load($formData)){
                    $p = ActiveForm::validate($passport);
                }
                echo Json::encode(array_merge($u,$p));
            }

        }

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

        $partsFormData = Yii::$app->request->post('UserAddationalContactForm', []);
        $count         = count($partsFormData);
        if ($count) {
            foreach ($partsFormData as $index => $value) {
                $addationals[$index] = new UserAddationalContactForm();
            }
        } elseif (count($info->addational)) {
            foreach ($info->addational as $index => $addational) {
                $add = new UserAddationalContactForm();
                $add->first_name = $addational['first_name'];
                $add->last_name = $addational['last_name'];
                $addationals[$index] = $add;
            }
        } else {
            if (empty($addationals)) {
                $addationals[] = new UserAddationalContactForm();
            }
        }

        $info->addationals = $addationals;

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
        $formValid = true;
        if (isset($post) && $info->load($post)) {
            if(isset($info->addationals)){
                if (Model::loadMultiple($info->addationals, Yii::$app->request->post()) && Model::validateMultiple($info->addationals)
                ) {
                } else {
                    $formValid = false;
                }
            }
        }
        if(isset($post['only_file'])){
            $formValid = true;
        }
        if($formValid){
            if(isset($post['only_file'])){
                $info->load($post);
                if ($info->save(false)) {
                    Yii::$app->getSession()->setFlash('success', 'Данные сохранены ');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Не удалось сохранить данные!<br/>' . CommonHelper::formatModelErrors($info));
                }
                header('Location: '.Url::to([
                    '/user/profile',
                ]));
                exit;
            } elseif ($info->load($post) && $user->load($post)) {
                $this->ajaxValidation([$user, $info]);
                if ($info->save() && $user->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Данные сохранены ');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Не удалось сохранить данные!<br/>' . CommonHelper::formatModelErrors($info));
                }
                if ($ad = Yii::$app->request->get('ad')) {
                    return $this->redirect(Url::to([
                        '/ads/view', 'id' => (int)$ad, 'c' => 1,
                    ]));
                }
                $this->redirect(Url::to([
                    '/user/profile',
                ]));
            }
        }
    }

    /**
     * Displays info card.
     *
     * @return string
     */
    public function actionCard($page)
    {
        if (!$info = UserInfo::find()->where('page_link=:p', ['p' => $page])->one()) {
            $this->throwNoPageFound();
        }
        $user = $info->user;
        /* @var $user User */

        return $this->render('info_card_manager', [
            'model'        => $info,
            'user'         => $user,
            'dataProvider' => $user->getMyActiveAds(),
        ]);
    }

    /**
     * Verify
     *
     * @return string
     */
    public function actionVerify()
    {
        $model = new ScreeningReport();
        $passport = UserPassport::find()->where(['user_id'=>Yii::$app->user->id])->one();

        if($model->checkPassport() OR $passport==null){
            yii::$app->getSession()->setFlash('success', 'Пожалуйста, заполните паспортные данные!');
            return $this->redirect('profile-update?verify=1#passport');
        }

        if(isset($passport->verify) AND $passport->verify==UserPassport::VERIFY_VERIFIED){
            yii::$app->getSession()->setFlash('success', 'Ваш аккаунт уже верифицерован!');
            return $this->redirect(['profile-update']);
        }

        //send request to Scorista
        $verify = new ScoristaAPI();
        $req = $verify->request(null,Yii::$app->user->id);
        if(isset($req->status) AND $req->status=='OK'){
            $passport->request_id = $req->requestid;
            $passport->verify = UserPassport::VERIFY_WAIT;
            $passport->update(false);
            yii::$app->getSession()->setFlash('success', 'Данные отправлены!');
            UserPassport::setVerify();
        }else{
            if(isset($req->status) AND $req->status=='ERROR' AND $req->error->code==400){
                yii::$app->getSession()->setFlash('error', 'Данные не отправлены! Попробуйте позже.<br/>Причина: '.$req->error->message);
            }else{
                $passport->is_scorista_wait = 1;
                $passport->update(false);
                yii::$app->getSession()->setFlash('success', 'Данные отправлены на проверку!');
            }
        }

        return $this->redirect(['profile-update']);
    }

    /**
     * Deletes an existing Ads model.
     * @param integer $id
     * @param integer $imgId
     * @return mixed
     */
    public function actionDeleteImage($imgId)
    {
        $passport = UserPassport::find()->where(['scan_passport'=>$imgId])->one();
        $deleted = false;
        if($passport){
            //if($passport->verify!=1){
                $passport->deleteScan();
                $passport->scan_passport = '';
                if($passport->save(false)){
                    $deleted = true;
                    //Yii::$app->getSession()->setFlash('success', 'Скан паспорт удалён');
                }
            //}

        }  
        $ar = [
            'result'  => ($deleted ? 'success' : 'success'),
            'message' => ($deleted ? 'ok' : 'Не удалось удалить cкан паспорт!'),
        ];
        return Json::encode($ar);
    }

    public function actionNameChanged()
    {
        $data = Yii::$app->request->post('User');
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user->first_name != $data['first_name'] || $user->last_name != $data['last_name'] || $user->middle_name != $data['middle_name'])
            return json_encode(['changed' => true]);
        return json_encode(['changed' => false]);
    }
}
