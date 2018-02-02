<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\helpers\CommonHelper;
use app\models\Ads;
use app\models\Applications;
use app\models\Config;
use app\models\LeaseContractParticipants;
use app\models\LeaseContracts;
use app\models\PaymentMethods;
use app\models\RealEstate;
use app\models\search\LeaseContractsSearch;
use app\models\search\PaymentMethodsAccountsSearch;
use app\models\search\PaymentMethodsCardsSearch;
use app\models\TransactionsLog;
use app\models\User;
use app\models\UserPassport;
use Dompdf\Dompdf;
use Dompdf\Options;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

/**
 * LeaseContractsController implements the CRUD actions for LeaseContracts model.
 */
class LeaseContractsController extends FrontendCabinetController
{
    
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all LeaseContracts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        $searchModel = new LeaseContractsSearch();
        
        if ($user->isCustomer) {
            $searchModel->participant_id = $user->id;
        } else {
            $searchModel->user_id = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('//_general/cabinet_wrapper', [
            'view'                => '//lease-contracts/index',
            'pageHeader'          => 'Договоры',
            'pageHeaderAddonView' => '//lease-contracts/_header_addon',
            'data'                => [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ],
        ]);
    }

	/**
	 * Lists all LeaseContracts models.
	 * @return mixed
	 */
	public function actionHistory()
	{
		$user = Yii::$app->user->identity;

		$searchModel = new LeaseContractsSearch();
		$searchModel->disabledOnly = true;

		if ($user->isCustomer) {
			$searchModel->participant_id = $user->id;
		} else {
			$searchModel->user_id = $user->id;
		}

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('//_general/cabinet_wrapper', [
			'view'                    => '//lease-contracts/history',
			'pageHeader'              => 'История договоров',
			'pageHeaderNoSearchInput' => true,
			//'pageHeaderAddonView' => '//lease-contracts/_header_addon',
			'data'                    => [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			],
		]);
	}
    
    /**
     *
     * Просмотр: Транзакции
     *
     */
    public function actionTransactions($id)
    {
        $model = $this->findModel($id);

        $rasxod = new TransactionsLog();
        $rasxod->type = TransactionsLog::TYPE_RASXOD;
        $rasxod->user_id = Yii::$app->user->id;
        $rasxod->contract_id = $id;

        $zach = new TransactionsLog();
        $zach->type = TransactionsLog::TYPE_ZACH;
        $zach->user_id = Yii::$app->user->id;
        $zach->contract_id = $id;

        if(isset(Yii::$app->request->isPost)){
            $post = Yii::$app->request->post();
            if(isset($post['TransactionsLog'])){
                if($post['TransactionsLog']['type']==TransactionsLog::TYPE_RASXOD){
                    $rasxod->load($post);
                    $this->ajaxValidation($rasxod);
                    if ($rasxod->validate()) {
                        $rasxod->date_pay = date('Y-m-d',strtotime($rasxod->date_pay));
                        if ($rasxod->save()) {
                            Yii::$app->getSession()->setFlash('success', 'Расход успешно добавлен!');
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Не удалось!');
                        }
                        $rasxod = new TransactionsLog();
                        $rasxod->type = TransactionsLog::TYPE_RASXOD;
                    }
                }elseif($post['TransactionsLog']['type']==TransactionsLog::TYPE_ZACH){
                    $zach->load($post);
                    $this->ajaxValidation($zach);
                    if ($zach->validate()) {
                        $zach->date_pay = date('Y-m-d',strtotime($zach->date_pay));
                        if ($zach->save()) {
                            Yii::$app->getSession()->setFlash('success', 'Зачисления успешно добавлены!');
                        } else {
                            Yii::$app->getSession()->setFlash('error', 'Не удалось!');
                        }
                        $zach = new TransactionsLog();
                        $zach->type = TransactionsLog::TYPE_ZACH;
                    }
                }
            }
        }
        
        return $this->render('view_wrapper', [
            'view'  => 'transactions/index',
            'model' => $model,
            'data'  => [
                'model' => $model,
                'rasxod' => $rasxod,
                'zach' => $zach,
                'waiting' => TransactionsLog::find()->where(['contract_id'=>(int)$id])->andWhere('date_pay >= '.new \yii\db\Expression('NOW()'))->all(),//,'user_id'=>Yii::$app->user->id
                'successed' => TransactionsLog::find()->where(['contract_id'=>(int)$id])->andWhere('date_pay < '.new \yii\db\Expression('NOW()'))->all(),//,'user_id'=>Yii::$app->user->id
            ],
        ]);
    }
    
    /**
     * Finds the LeaseContracts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return LeaseContracts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $user_id               = Yii::$app->user->id;
        $participantsTableName = LeaseContractParticipants::tableName();
        
        $model = LeaseContracts::find()
                               ->alias('t')
                               ->joinWith(['participants'])
                               ->where([
                                   't.id'      => (int)$id,
                                   't.user_id' => $user_id,
                               ])
                               ->orWhere([
                                   't.id'                              => (int)$id,
                                   $participantsTableName . '.user_id' => $user_id,
                               ])
                               ->one();
        
        if ($model !== null) {
            return $model;
        } else {
            $this->throwNoPageFound();
        }
    }
    
    /**
     *
     * Просмотр: Договор
     *
     */
    public function actionContract($id)
    {
        $model = $this->findModel($id);

        if (isset(Yii::$app->params['new_lc_part_counter']) AND Yii::$app->params['new_lc_part_counter'] > 0) {
            $lcp = LeaseContractParticipants::find()->where(['lease_contract_id'=>(int)$id,'user_id'=>Yii::$app->user->id])->one();
            if ($lcp AND $lcp->is_new == 1) {
                $lcp->markViewed();
                Yii::$app->params['new_lc_part_counter'] = LeaseContractParticipants::getNewCount();
            }
        }

        /*Muxtor*/
        //Расторнут договор
        if(isset($_GET['disable'])){
            $model->status = LeaseContracts::STATUS_IN_DISABLE;
            $model->date_disable = strtotime("+30 days");
            if($model->user_id == Yii::$app->user->id){
                $model->sendContractInDisableMessage();//Нанимателю
            }else{
                $model->sendContractInDisableMessage($model->user_id);//Собственнику
            }
            $model->save(false);

	        $targetPerson = Yii::$app->user->id === $model->user_id ? 'Нанимателю' : 'Собственнику';
	        $disableDate = date('Y-m-d', strtotime("+30 days"));

	        Yii::$app->getSession()->setFlash('success', 'Уведомление о расторжении направлено ' . $targetPerson . '. Договор будет расторгнут ' . $disableDate . '.');

            return $this->redirect(['contract', 'id' => $model->id]);
        }
        //Отозвать договор у подписателей.
        if(isset($_GET['cancel'])){
            $model->status = LeaseContracts::STATUS_CANCELED;
            if(Yii::$app->user->id === $model->user->id){
                $model->save(false);
                $model->sendContractCancelMessageParts();
                //LeaseContractParticipants::deleteAll('lease_contract_id=:id',[':id'=>$id]);
            }
            Yii::$app->getSession()->setFlash('success', 'Договор отозван!');

            return $this->redirect(['contract', 'id' => $model->id]);
        }
        
        $partsFormData = Yii::$app->request->post('User', []);
        $count         = count($partsFormData);

        if ($count) {
            foreach ($partsFormData as $index => $value) {
                $participants[$index] = new User(['scenario' => User::SCENARIO_FIND_PARTICIPANT]);
            }
        } elseif (count($model->participants)) {
            foreach ($model->participants as $participant) {
                $participants[] = $participant->user;
            }
        } else {
            if (empty($participants)) {
                $participants[] = new User(['scenario' => User::SCENARIO_FIND_PARTICIPANT]);
            }
        }

        $formValid = true;
        if (Yii::$app->request->post()) {

            if (Model::loadMultiple($participants,Yii::$app->request->post()) && Model::validateMultiple($participants)
            ) {
                foreach ($participants as $participant) {
                    if ($model->user->email == $participant->email) {
                        $participant->addError('email', 'Email не может совпадать с Вашим');
                        $formValid = false;
                    }
                }
            }


            if ($formValid) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $userIds = [];
                    $userIdsUps = [];
                    foreach ($participants as $participant) {
                        $user = User::findOne(['email' => $participant->email]);

                        if ($user === null) {
                            $user = new User(['scenario' => User::SCENARIO_FIND_PARTICIPANT]);
                            $user->status   = User::STATUS_ACTIVE;
                            $password = Yii::$app->security->generateRandomString(6);
                            $user->password = $password;
                            $user->email = $participant->email;

                            $splitFio = explode(' ',$participant->first_name);
                            if (count($splitFio)==2)
                            {
                                $user->first_name = $splitFio[1];
                                $user->last_name = $splitFio[0];
                            }
                            elseif (count($splitFio)==3)
                            {
                                $user->first_name = $splitFio[1];
                                $user->last_name = $splitFio[0];
                                $user->middle_name = $splitFio[2];
                            }else{
                                $user->first_name = $participant->first_name;
                                $user->last_name = '';
                            }
                            $user->validate();

                            if ($user->save(false)) {
                                $user->assignRole(User::ROLE_CUSTOMER, User::ROLE_CUSTOMER);
                                $userIdsUps[] = $user->id;

                                Yii::$app->mailer->compose('sign-up-contract', [
                                    'user'     => $user,
                                    'password' => $password,
                                    'contract' => $model,
                                ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                                    ->setTo($user->email)
                                    ->setSubject('Вы были добавлены как участник Договора на ' . CommonHelper::data()->getParam('tld',
                                            'arenda.ru'))
                                    ->send();

                            }
                        }

                        $userIds[] = $user->id;
                    }

                    $oldParts = LeaseContractParticipants::find()
                        ->where(['lease_contract_id' => $model->id])
                        ->andWhere(['NOT IN', 'user_id', $userIds])
                        ->all();

                    foreach ($oldParts as $oldPart) {
                        $oldPart->delete();
                    }

                    foreach ($userIds as $uId) {
                        $connect = LeaseContractParticipants::find()->where([
                            'user_id'           => $uId,
                            'lease_contract_id' => $model->id,
                        ])->one();

                        if ($connect === null) {
                            $connect = new LeaseContractParticipants([
                                'user_id'           => $uId,
                                'lease_contract_id' => $model->id,
                            ]);
                            if($connect->save()){
                                if(!isset($userIdsUps[$uId])){
                                    $user = User::findOne(['id' => $uId]);

                                    Yii::$app->mailer->compose('contract-added', [
                                        'user'     => $user,
                                        'contract' => $model,
                                    ])->setFrom(CommonHelper::data()->getParam('supportEmail'))
                                        ->setTo($user->email)
                                        ->setSubject('Вы были добавлены как участник Договора на ' . CommonHelper::data()->getParam('tld',
                                                'arenda.ru'))
                                        ->send();
                                }
                            }
                        }
                    }

                    $transaction->commit();

	                return $this->refresh();

                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('view_wrapper', [
            'view'  => 'contract/index',
            'model' => $model,
            'data'  => [
                'model' => $model,
                'participants' => $participants,
            ],
        ]);
    }
    
    /**
     *
     * Просмотр: жильцы
     *
     */
    public function actionParticipants($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view_wrapper', [
            'view'  => 'participants/index',
            'model' => $model,
            'data'  => [
                'model' => $model,
            ],
        ]);
    }

    /**
     *
     * Просмотр: История
     *
     */
    public function actionRentHistory($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view_wrapper', [
            'view'  => 'rent_history/index',
            'model' => $model,
            'data'  => [
                'model' => $model,
            ],
        ]);
    }
    /**
     *
     * Просмотр: Оплата ЖКХ
     *
     */
    public function actionPayjkx($id)
    {
        $model = $this->findModel($id);

        return $this->render('view_wrapper', [
            'view'  => 'payjkx/index',
            'model' => $model,
            'data'  => [
                'model' => $model,
            ],
        ]);
    }
    
    /**
     * Displays a single LeaseContracts model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    /**
     * Creates a new LeaseContracts model.
     *
     * @param null $id
     * @param null $appId
     * @param null $eId
     * @param int $step
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($id = null, $appId = null, $eId = null, $step = 1, $forceSave = null)
    {
        $customer = Yii::$app->user->identity;
        if ($customer->hasRole([User::ROLE_CUSTOMER])) {
            Yii::$app->getSession()->setFlash('success', 'Редактировать договор может только собственник!');
            return $this->redirect(['contract', 'id' => $id]);
        }

        $verify = UserPassport::find()->where(['user_id'=>Yii::$app->user->id])->one();
        if ( $verify==null){
            Yii::$app->getSession()->setFlash('success', 'Пожалуйста, пройти верификацию!');
            return $this->redirect('/user/profile-update?contract=yes#passport');
        }
        if ( $verify!=null){
            if($verify->verify != UserPassport::VERIFY_VERIFIED) {
                Yii::$app->getSession()->setFlash('success', 'Пожалуйста, пройти верификацию!');
                return $this->redirect('/user/profile-update?contract=yes#passport');
            }
        }

        $scenario = null;
        switch ($step) {
            case 1:
                $scenario = LeaseContracts::SCENARIO_STEP_1;
                break;
            case 2:
                $scenario = LeaseContracts::SCENARIO_STEP_2;
                break;
            case 3:
                $scenario = LeaseContracts::SCENARIO_STEP_3;
                break;
            case 4:
                $scenario = LeaseContracts::SCENARIO_STEP_4;
                break;
	        case 5:
		        $scenario = LeaseContracts::SCENARIO_STEP_5;
		        break;
        }
        
        if ($scenario === null) {
            throw new InvalidParamException('Неправильные параметры');
        }

        $participants = [];
        //$participants[] = new User(['scenario' => User::SCENARIO_FIND_PARTICIPANT]);
        
        if ($id === null) {
            $model = new LeaseContracts(['scenario' => $scenario]);

	        if ($eId != null) {
		        $estate = RealEstate::findOne([
			        'id'      => $eId,
			        'user_id' => Yii::$app->user->id,
		        ]);

		        if ($estate == null) {
			        throw new NotFoundHttpException('Недвижимость не найдена');
		        }

		        $draftContract = LeaseContracts::findOne([
			        'real_estate_id' => $estate->id,
			        'user_id'        => Yii::$app->user->id,
			        'status'         => LeaseContracts::STATUS_DRAFT,
		        ]);

		        $redirectParams = [
			        'create',
		        ];

		        if ($draftContract) {
			        $redirectParams['id'] = $draftContract->id;
		        } else {
			        $model->real_estate_id = $estate->id;
			        $model->user_id = Yii::$app->user->id;

			        // Тянем из объявления удобства
			        if ($step == 1 AND $model->isNewRecord) {
				        $ads = Ads::findOne([
					        'real_estate_id' => $model->real_estate_id,
				        ]);

				        if ($ads != null) {
					        $model->facilities = $ads->facilities;
					        $model->facilities_other = $ads->facilities_other;
				        }
			        }

			        if ($model->save(false)) {
				        $redirectParams['id'] = $model->id;
			        } else {
				        throw new InvalidParamException('Не удалось создать договор');
			        }
		        }

		        $redirectParams['step'] = 1;

		        if ($appId != null) {
			        $redirectParams['appId'] = $appId;
		        }

		        return $this->redirect($redirectParams);

	        } else {
		        //throw new InvalidParamException('Неправильные параметры созднания договора');
	        }

        } else {

            //$customer = Yii::$app->user->identity;

            /*if($customer->hasRole([User::ROLE_CUSTOMER])){
                $parTablename = LeaseContractParticipants::tableName();
                $model = LeaseContracts::find()
                    ->alias('t')
                    ->joinWith(['participants'])
                    ->where([
                        $parTablename.".lease_contract_id"      => (int)$id,
                        $parTablename.".user_id" => Yii::$app->user->id,
                    ])->one();
            }else{
                $model = LeaseContracts::findOne([
                    'id'      => $id,
                    'user_id' => Yii::$app->user->id,
                ]);
            }*/

            $model = LeaseContracts::findOne([
                'id'      => $id,
                'user_id' => Yii::$app->user->id,
            ]);


            if ($model == null) {
                throw new NotFoundHttpException('Договор не найден');
            }

            if ($model->status == LeaseContracts::STATUS_IN_DISABLE) {
                //throw new NotFoundHttpException('Договор нельзя редактировать');
                Yii::$app->getSession()->setFlash('success', 'Договор нельзя редактировать!');
                return $this->redirect(['contract', 'id' => $model->id]);
            }

            if ($model->status != LeaseContracts::STATUS_DISABLED) {
                //throw new NotFoundHttpException('Договор нельзя редактировать');
            }

            $model->scenario = $scenario;
        }

            if ($appId != null) {
                $app = Applications::findOne(['id' => $appId]);

                if ($app == null) {
                    throw new NotFoundHttpException('Заявка не найдена');
                }

                $participants[] = $app->user;
            }

            if ($step == 2) {
                $ads = Ads::findOne([
                    'real_estate_id' => $model->real_estate_id,
                ]);
                if($model->isNewRecord){
                    if ($ads != null) {
                        $model->price_per_month = floatval($ads->rent_cost_per_month);
                        $model->deposit_sum = floatval($ads->rent_cost_per_month);
                    } else {
                        $model->price_per_month = 0;
                        $model->deposit_sum = 0;
                    }
                }else{
                    $model->price_per_month =  floatval($model->price_per_month);
                    $model->deposit_sum =  floatval($model->deposit_sum);
                }

            }

            $payment = [];
            if ($step == 3) {
                $searchModelCards    = new PaymentMethodsCardsSearch();
                $searchModelAccounts = new PaymentMethodsAccountsSearch();

                $dataProviderCards    = $searchModelCards->search(array_merge(Yii::$app->request->queryParams,
                    ['user_id' => Yii::$app->user->id]));
                $dataProviderAccounts = $searchModelAccounts->search(array_merge(Yii::$app->request->queryParams,
                    ['user_id' => Yii::$app->user->id]));

                $payment = [
                    'dataProviderCards'    => $dataProviderCards,
                    'dataProviderAccounts' => $dataProviderAccounts,
                ];
            }

            $formValid = true;
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->id;

                if ($forceSave !== null && Yii::$app->request->isAjax) {
                    // Через AJAX можно сейвить без валидации - например когда хотим уйти на другую страницу
                    return $model->save(false);
                }

                $formValid = $model->validate();

                if ($formValid) {
                    $transaction = Yii::$app->db->beginTransaction();

                    try {
                        if ($model->save()) {

                            $transaction->commit();

                            $nextStep = $step + 1;

                            if ($id === null && $model->scenario == LeaseContracts::SCENARIO_STEP_1) {
                                return $this->redirect(['create', 'id' => $model->id, 'step' => $nextStep]);
                            }

                            if ($id !== null && $step != LeaseContracts::STEPS_COUNT) {
                                return $this->redirect(['create', 'id' => $model->id, 'step' => $nextStep]);
                            }

                            if ($id !== null && $step == LeaseContracts::STEPS_COUNT) {
                                $model->status = LeaseContracts::STATUS_NEW;

                                $buttonAction = Yii::$app->request->post('button-action', 'save');

                                if ($model->save()) {
                                    LeaseContractParticipants::updateAll(['signed'=>0],'lease_contract_id=:id',[':id'=>$model->id]);
                                    $model->sendContractResignMessage();
                                    if ($buttonAction == 'save-n-sign') {
                                        return $this->redirect(['sign', 'id' => $model->id]);
                                    } else {
                                        return $this->redirect(['contract', 'id' => $model->id]);
                                    }
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }

            return $this->render('//_general/cabinet_full_wrapper', [
                'view'          => '//lease-contracts/create',
                'pageHeader'    => 'Новый договор',
                'pageSubHeader' => ($model->estate !== null) ? $model->estate->getFullAddress() : '',
                'data'          => [
                    'step'         => $step,
                    'stepView'     => $model->scenario,
                    'model'        => $model,
                    'participants' => $participants,
                    'payment'      => $payment,
                ],
            ]);
        }

        /**
         * save model data
         *
         * @param LeaseContracts $model
         *
         * @return LeaseContracts
         */
    public function saveModel($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            
            $this->ajaxValidation($model);
            
            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Данные сохранены!');
                
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->setFlash('error', CommonHelper::formatModelErrors($model));
                $this->refresh();
            }
        }
        
        return $model;
    }
    
    /**
     * Deletes an existing LeaseContracts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        LeaseContractParticipants::deleteAll('lease_contract_id=:id',[':id'=>$id]);
        $model->delete();
        Yii::$app->getSession()->setFlash('success', 'Договор удален!');
        
        return $this->redirect(['index']);
    }
    /**
     * Удалить себя из договора арендодателя
     */
    public function actionDeletepart($id)
    {
        $user = Yii::$app->user->identity;
        LeaseContractParticipants::deleteAll('lease_contract_id=:id AND user_id=:user',[':id'=>$id,':user'=>$user->id]);
        Yii::$app->getSession()->setFlash('success', 'Договор удален!');
        
        return $this->redirect(['index']);
    }
    
    public function actionSearchCustomers()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $keyword                    = Yii::$app->request->get('keyword');
        
        $concat    = "concat({{%user}}.username,' - [',{{%user}}.email,']')";
        $customers = User::findByRole(User::ROLE_CUSTOMER)
                         ->select(['{{%user}}.id', "{{%user}}.username as text"])
                         ->andWhere(['like', $concat, (string)$keyword])
                         ->asArray()
                         ->all();
        
        return ['results' => ArrayHelper::toArray($customers, 'id', 'text')];
    }
    
    public function actionSign($id)
    {
        $model = $this->findModel($id);

        
        if ($model == null) {
            throw new NotFoundHttpException('Договор не найден');
        }

	    $user = Yii::$app->user->identity;

        if ($model->user_id == $user->id) {
            $parted = LeaseContractParticipants::find()->where(['lease_contract_id'=>(int)$id])->one();
            if ( $parted==null){
                Yii::$app->getSession()->setFlash('success', 'Пожалуйста, пригласить жилец в договор');
                return $this->redirect(['/lease-contracts/contract','id'=>(int)$id]);
            }
            if ( $parted!=null){
                if($parted->signed != 1) {
                    Yii::$app->getSession()->setFlash('success', 'Пожалуйста, ожидайте подпись жильца');
                    return $this->redirect(['/lease-contracts/contract','id'=>(int)$id]);
                }
            }
	        $model->scenario = LeaseContracts::SCENARIO_SIGN;
	        $participant = $model;
        } else {
            if ($model->estate->check_status != RealEstate::CHECK_STATUS_SUCCESS){
                if($model->estate->check_status == RealEstate::CHECK_STATUS_ERROR){
                    Yii::$app->getSession()->setFlash('success', 'Объект не прошел проверку');
                }else{
                    Yii::$app->getSession()->setFlash('success', 'Объект проходит проверку');
                }
                return $this->redirect(['/lease-contracts/index']);
            }

	        $model->scenario = LeaseContracts::SCENARIO_CHECK_CODE;

	        $participant = null;
	        foreach ($model->participants as $p) {
		        if ($p->user_id == $user->id) {
			        $participant = $p;
			        break;
		        }
	        }

	        if ($participant != null) {
		        $participant->scenario = LeaseContractParticipants::SCENARIO_SIGN;
                if (isset($user->passport->verify) AND $user->passport->verify!=\app\models\UserPassport::VERIFY_VERIFIED){
                    Yii::$app->getSession()->setFlash('success', 'Пожалуйста, пройти верификацию');
                    return $this->redirect(['/user/profile-update#passport']);
                    //throw new NotAcceptableHttpException('Для подписания договора вы должны пройти верификацию');
                }
	        }
        }

	    if ($participant == null) {
		    throw new NotFoundHttpException('Вы не участник договора');
	    }

        if ($model->isSignedByUser($user->id)) {
            throw new NotFoundHttpException('Вы уже подписали договор');
        }

        if(!$model->checkContract()){
            //throw new NotAcceptableHttpException('Объект уже сдан другому участнику системы');
        }
        
        $passport = $user->passport;
        if ($passport == null) {
            $passport          = new UserPassport();
            $passport->user_id = Yii::$app->user->id;
            $passport->save();
        }

        // Заполняем ФИО из Пасспорта
        $participant->signed_fio = $user->getFullNameAll();

        $formValid = true;
        if ($model->load(Yii::$app->request->post())) {
            $this->ajaxValidation($model);
            $formValid = $model->validate();
            if ($passport->load(Yii::$app->request->post())) {
                $this->ajaxValidation($passport);
                if($passport->validate()){

                }else{
                    $formValid = false;
                }
                //
            } else {
                $formValid = false;
            }
            
            if ($participant->load(Yii::$app->request->post()) && $participant->validate()) {
                if ($participant instanceof $model) {
                	// Небольшой костыль
	                $model->status = LeaseContracts::STATUS_SIGNED_BY_OWNER;
	                $participant->status = LeaseContracts::STATUS_SIGNED_BY_OWNER;
                }
            } else {
                $formValid = false;
            }
            
            if ($formValid) {
                $transaction = Yii::$app->db->beginTransaction();
                
                try {
                    if ($participant->save() && $passport->save()) {
                        if ($model->user_id == $user->id) {
                            $model->tryActivate();
                            Yii::$app->getSession()->setFlash('success', $model->user->getFullNameAll().' поздравляем Вас. Только что вы заключили договор наима №'.$model->id.'.');
                        }else{
                            $model->status =LeaseContracts::STATUS_NEW;
                            $model->update(false);
                            $partUser = User::findOne(Yii::$app->user->id);
                            Yii::$app->getSession()->setFlash('success', 'Договор №'.$model->id.' успешно подписан '.$partUser->getFullNameAll().' договор отправлен на подписание собственнику '.$model->user->getFullNameAll().'.');
                        }
                        
                        $transaction->commit();
                        return $this->redirect(['/lease-contracts/contract','id'=>(int)$id]);
                    } else {
                        $transaction->rollBack();
                        throw new NotFoundHttpException('Ошибка');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
        return $this->render('//_general/cabinet_full_wrapper', [
            'view'          => '//lease-contracts/sign',
            'pageHeader'    => 'Подписание договора',
            'pageSubHeader' => ($model->estate !== null) ? $model->estate->getFullAddress() : '',
            'data'          => [
                'model'       => $model,
                'participant' => $participant,
                'passport'    => $passport,
            ],
        ]);
    }
    
    public function actionSignSms()
    {
        $user = Yii::$app->user->identity;
        
        $phone = $user->phone;
        
        //$code = '0000';
        //Yii::$app->session->set(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY, $code);
        
        if ($phone !== null && $phone != '') {
            $code = $this->genererateRandomNumbers();
            
            Yii::$app->session->set(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY, $code);
            
            \Yii::$app->sms->sms_send($phone, 'Код подтверждения: ' . $code, 'arenda' );
        }
        
        echo Yii::$app->session->get(LeaseContracts::SESSION_SMS_CONTRACT_SIGN_KEY);
        //echo 'ok';
    }
    
    public function actionDownload()
    {
        $model = LeaseContracts::findOne(Yii::$app->request->get('contract_id'));
        $config = Config::findOne(1);
    
        $document = $this->renderPartial('pdf', compact('model', 'config'));
    
        $pdfOptions = new Options();
        $pdfOptions->set('default_paper_size', 'a4');
        $domPdf = new Dompdf($pdfOptions);
        $domPdf->loadHtml($document);
        $domPdf->render();

        $domPdf->stream("Agreement-{$model->id}.pdf");
    }
}
