<?php

namespace app\controllers;

use app\components\extend\FrontendCabinetController;
use app\components\helpers\CommonHelper;
use app\components\ScoristaAPI;
use yii;
use app\models\search\ScreeningRequestSearch;
use app\components\extend\FrontendController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\ScreeningRequest;
use app\models\ScreeningReport;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * ApplicationsController implements the CRUD actions for Applications model.
 */
class ScriningController extends FrontendCabinetController
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
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
					'delete' => ['POST'],
				],
			],
		]);
	}

	public function actionRequests()
	{
		$searchModel = new ScreeningRequestSearch();
		$searchModel->user_id = yii::$app->user->id;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('//_general/cabinet_wrapper', [
			'view'                    => '//scrining/requests',
			'pageHeader'              => 'Проверка данных',
			'pageHeaderAddonView'     => '//scrining/_header_addon_request',
			'pageHeaderNoSearchInput' => true,
			'data'                    => [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			],
		]);
	}
	
	public function actionOrders()
	{
		$reports = $this->getUserReports();
		if (count($reports) < 2) {
			$types = [
				ScreeningRequest::TYPE_FULL => true,
				ScreeningRequest::TYPE_CREDIT => true,
				ScreeningRequest::TYPE_BIO => true,
			];
			foreach ($reports as $type => $report) {
				unset($types[$type]);
			}
			$requests = ScreeningRequest::find()
				->where(['and', 
					['type' => array_keys($types)],
					['or',
						['reporter_id' => yii::$app->user->id],
						['email' => yii::$app->user->identity->email],
					],
				])
				->all();
		} else {
			$requests = [];
		}
		
		return $this->render('//_general/cabinet_wrapper', [
			'view'                    => '//scrining/orders',
			'pageHeader'              => 'Проверка данных',
			'pageHeaderAddonView'     => count($reports) < 2 ? '//scrining/_header_addon_order' : false,
			'pageHeaderNoSearchInput' => true,
			'data'                    => [
				'reports' => $reports,
				'requests' => $requests,
			],
		]);
	}
	
	public function actionRequest()
	{
		$models = [new ScreeningRequest()];
		if(isset($_GET['userid'])){
			$user = User::findOne((int) $_GET['userid']);
			if($user!=null){
				$models[0]->email = $user->email;
				$models[0]->name_first = $user->first_name;
				$models[0]->name_last = $user->last_name;
			}

		}

		$post = Yii::$app->request->post();
		if (isset($post['requests']) && $post['type']) {
			$type = $post['type'];
			$valid = true;
			$models = [];
			foreach ($post['requests'] as $request) {
				$model = new ScreeningRequest();
				$model->attributes = $request;
				$valid = $model->validate() && $valid;
				$models[] = $model;
			}
			if ($valid) {
				foreach ($models as $model) {
					$model->sendRequest($type);
				}
				yii::$app->getSession()->setFlash('success', 'Заявка отправлена!');
				return $this->redirect(['requests']);
			}
		}
		
		return $this->render('//scrining/request', [
			'models' => $models,
		]);
	}
	
	public function actionCreate($type='')
	{
		$model = new ScreeningReport();
		if($model->checkPassport()){
			yii::$app->getSession()->setFlash('success', 'Пожалуйста, заполните паспортные данные!');
			return $this->redirect('/user/profile-update?scrining='.$type.'#passport');
		}
		$reports = $this->getUserReports();
		/*$valids = count($reports);
		$i = 0;
		foreach ($reports as $model){
			if($model->status == ScreeningReport::STATUS_VALID){
				$i++;
			}
		}

		if($valids > 0 AND $valids == $i){
			yii::$app->getSession()->setFlash('success', 'Вы прошли проверку!');
			return $this->redirect(['orders']);
		}else*/
		if (count($reports) >= 2) {
			yii::$app->getSession()->setFlash('success', 'Вы уже отправляли заявки на оба типа отчета!');
			return $this->redirect(['orders']);
		}
		
		if ($model->load(Yii::$app->request->post())) {
			$this->ajaxValidation($model);
			if ($model->validate()) {
				$model->sendReports();
				yii::$app->getSession()->setFlash('success', 'Данные отправлены!');
				return $this->redirect(['orders']);
			}
		} else {
			$types = [];
			if ($type == ScreeningRequest::TYPE_BIO || $type == ScreeningRequest::TYPE_FULL) {
				if (!isset($reports[ScreeningReport::TYPE_BIO])) {
					$types[] = ScreeningReport::TYPE_BIO;
				}
			}
			if ($type == ScreeningRequest::TYPE_CREDIT || $type == ScreeningRequest::TYPE_FULL) {
				if (!isset($reports[ScreeningReport::TYPE_CREDIT])) {
					$types[] = ScreeningReport::TYPE_CREDIT;
				}
			}
			$user = Yii::$app->user->identity;
			$model->loadFromUserData($user);
			if($types==null){
                $types[] = ScreeningReport::TYPE_BIO;
                $types[] = ScreeningReport::TYPE_CREDIT;
            }
            $model->type = $types;
		}
		
		return $this->render('//_general/cabinet_wrapper_bg', [
			'view'                    => '//scrining/create',
			'pageHeader'              => 'Подтверждение и оплата запроса проверки данных',
			'pageHeaderNoSearchInput' => true,
			'noBackground' => false,
			'data'                    => [
				'model' => $model,
				'reports' => $reports,
			],
		]);
	}
	
	protected function getUserReports()
	{
		$reports = [];
		foreach (ScreeningReport::findAll(['user_id' => yii::$app->user->id]) as $report) {
			$reports[$report->type] = $report;
		}
		return $reports;
	}
	public function actionBiometric($reportid,$reqid){
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		Yii::$app->html2pdf
			->render('pdf_bio', ['model' => $model,'report'=>$report])
			->saveAs(CommonHelper::data()->getParam('pdfs').'/Report-bio-'.$reqid.'.pdf');
		return $this->redirect(CommonHelper::data()->getParam('pdfsweb').'/Report-bio-'.$reqid.'.pdf');
	}
	public function actionCredit($reportid,$reqid){
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		Yii::$app->html2pdf
			->render('pdf_credit', ['model' => $model,'report'=>$report])
			->saveAs(CommonHelper::data()->getParam('pdfs').'/Report-credit-'.$reqid.'.pdf');
		return $this->redirect(CommonHelper::data()->getParam('pdfsweb').'/Report-credit-'.$reqid.'.pdf');
	}

	public function actionBiometricold($reportid,$reqid){
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		$document = $this->renderPartial('pdf_bio', compact('model','report'));

		$pdfOptions = new Options();
		$pdfOptions->set('dpi', 336);
		$pdfOptions->set('isPhpEnabled', true);
		$pdfOptions->set('isRemoteEnabled', true);
		$pdfOptions->set('isHtml5ParserEnabled', true);
		$pdfOptions->set('default_paper_size', 'a4');
		$domPdf = new Dompdf($pdfOptions);
		$domPdf->loadHtml($document);
		$domPdf->render();

		$domPdf->stream("Report-bio-{$reportid}.pdf");
	}
	public function actionCreditold($reportid,$reqid){
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		$document = $this->renderPartial('pdf_credit', compact('model','report'));

		$pdfOptions = new Options();
		$pdfOptions->set('dpi', 336);
		$pdfOptions->set('isPhpEnabled', true);
		$pdfOptions->set('isRemoteEnabled', true);
		$pdfOptions->set('isHtml5ParserEnabled', true);
		$pdfOptions->set('default_paper_size', 'a4');
		$domPdf = new Dompdf($pdfOptions);
		$domPdf->loadHtml($document);
		$domPdf->render();

		$domPdf->stream("Report-credit-{$reportid}.pdf");
	}
	public function actionBiometrichtml($reportid,$reqid){
		$this->layout = 'empty';
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		return $this->render('//scrining/pdf_bio', ['report'=>$report,'model'=>$model]);
	}
	public function actionCredithtml($reportid,$reqid){
		$this->layout = 'empty';
		$report = ScreeningReport::findOne($reportid);
		if(empty($report->result)){
			$scorista = new ScoristaAPI();
			$model = $scorista->checkRequest($reqid);
		}else{
			$model = json_decode($report->result);
		}

		if($model->status=='DONE'){
			$report->result = json_encode($model);
			$report->update(false);
		}

		return $this->render('//scrining/pdf_credit', ['report'=>$report,'model'=>$model]);
	}
}
