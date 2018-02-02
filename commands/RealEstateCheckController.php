<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 12.04.2017
 * Time: 10:29
 */

namespace app\commands;


use app\components\XZPDocumentParser;
use app\models\RealEstate;
use app\models\RealEstateCadastr;
use app\models\RealEstateOwner;
use yii\console\Controller;

class RealEstateCheckController extends Controller
{
    public function actionIndex(){
        $estates = RealEstate::find()->checkStart()->all();
        foreach ($estates as $estate) {
            echo $estate->getReestrSearchAddress() . PHP_EOL;
            $cadastr = $estate->searchCadastr();
            if (!$cadastr) {
                $estate->check_status = RealEstate::CHECK_STATUS_ERROR;
                $estate->save();
                echo 'Адрес не найден' . PHP_EOL;
                continue;
            }

            if ($cadastr->status == RealEstateCadastr::STATUS_NOT_RUN) {
                $cadastr->loadInfo();
                $cadastr->status = RealEstateCadastr::STATUS_IN_PROCESS;
                $cadastr->save();

                $estate->check_status = RealEstate::CHECK_STATUS_IN_PROCESS;
                $estate->cadastr_number = $cadastr->cadastr_number;
                $estate->save();
            }
        }

        $runCadastres = RealEstateCadastr::find()->inProcess()->all();
        foreach ($runCadastres as $cadastr) {
            if ($cadastr->pay()) {
                $cadastr->status = RealEstateCadastr::STATUS_PAID;
            } else {
                $cadastr->status = RealEstateCadastr::STATUS_ERROR;
                $cadastr->error = RealEstateCadastr::ERROR_NOT_PAID;
            }
            $cadastr->save();
        }

        echo 'Получение документов' . PHP_EOL;
        /** @var RealEstateCadastr[] $paidCadastres */
        $paidCadastres = RealEstateCadastr::find()->paid()->all();
        foreach ($paidCadastres as $cadastr) {
            echo $cadastr->document_id . PHP_EOL;
            if (!$cadastr->loadDocument()) {
                echo 'Документ ещё не готов' . PHP_EOL;
                continue;
            }
            $estate = $cadastr->realEstate;
            $parser = new XZPDocumentParser();
            $parser->parse($cadastr->document);

            RealEstateOwner::deleteAll(['real_estate_id' => $estate->id]);

            $fio_success = false;
            foreach ($parser->owners as $owner) {
                $ownerModel = new RealEstateOwner();
                $ownerModel->real_estate_id = $estate->id;
                $ownerModel->fio = $owner;
                $ownerModel->save();
                if ($owner = $estate->user->getFullNameAll())
                    $fio_success = true;
            }
            $estate->registration_law_kind = $parser->registration_law_kind;
            $estate->registration_law_number = $parser->registration_law_number;
            $estate->registration_law_date = $parser->registration_law_date;
            $estate->encumbrance = $parser->encumbrance;
            $estate->seizure = $parser->seizure;
            $estate->third_party_problem = $parser->third_party_problem;
            if ($fio_success) {
                $estate->check_status = RealEstate::CHECK_STATUS_SUCCESS;
            } else {
                $estate->check_status = RealEstate::CHECK_STATUS_ERROR;
            }
            $estate->save();

            $cadastr->status = RealEstateCadastr::STATUS_COMPLETED;
            $cadastr->save();
            var_dump($cadastr->errors);
        }
    }
}