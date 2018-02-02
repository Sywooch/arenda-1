<?php

namespace app\models;

use app\components\helpers\CadastrHelper;
use Yii;
use yii\httpclient\Client;

/**
 * This is the model class for table "ar_real_estate_cadastr".
 *
 * @property int $id
 * @property string $cadastr_number
 * @property string $object_type
 * @property string $object_status
 * @property string $staging_date
 * @property int $floor
 * @property double $area
 * @property string $area_units
 * @property double $cadastr_cost
 * @property string $cost_deposit_date
 * @property string $cost_approval_date
 * @property string $valuation_date
 * @property string $address
 * @property string $oks
 * @property string $encoded_object
 * @property string $confirm_code
 * @property string $info_update_date
 * @property int $transaction_id
 * @property int $document_id
 * @property int $status
 * @property int $error
 * @property string $document
 *
 * @property RealEstate $realEstate
 */
class RealEstateCadastr extends \yii\db\ActiveRecord
{
    const STATUS_NOT_RUN = 0;
    const STATUS_IN_PROCESS = 1;
    const STATUS_PAID = 2;
    const STATUS_COMPLETED = 4;
    const STATUS_ERROR = 5;

    const ERROR_NOT_FOUND = 1;
    const ERROR_NOT_PAID = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar_real_estate_cadastr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floor', 'transaction_id', 'document_id', 'status', 'error'], 'default', 'value' => null],
            [['floor', 'transaction_id', 'document_id', 'status', 'error'], 'integer'],
            [['staging_date', 'cost_deposit_date', 'cost_approval_date', 'valuation_date', 'info_update_date'], 'safe'],
            [['area', 'cadastr_cost'], 'number'],
            [['address', 'oks', 'encoded_object', 'confirm_code', 'document'], 'string'],
            [['cadastr_number', 'object_type', 'object_status', 'area_units'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cadastr_number' => 'Cadastr Number',
            'object_type' => 'Object Type',
            'object_status' => 'Object Status',
            'staging_date' => 'Staging Date',
            'floor' => 'Floor',
            'area' => 'Area',
            'area_units' => 'Area Units',
            'cadastr_cost' => 'Cadastr Cost',
            'cost_deposit_date' => 'Cost Deposit Date',
            'cost_approval_date' => 'Cost Approval Date',
            'valuation_date' => 'Valuation Date',
            'address' => 'Address',
            'oks' => 'Oks',
            'info_update_date' => 'Info Update Date',
            'transaction_id' => 'Transaction ID',
            'document_id' => 'Document ID',
            'status' => 'Status',
            'error' => 'Error',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealEstate()
    {
        return $this->hasOne(RealEstate::className(), ['cadastr_number' => 'cadastr_number']);
    }

    public function loadInfo()
    {
        $response = $this->getObjectInfo();
        $details = $response['EGRN']['details'];

        $this->object_type = $details['Тип объекта'];
        $this->object_status = $details['Статус объекта'];
        $this->staging_date = CadastrHelper::normalizeDate($details['Дата постановки на кадастровый учет']);
        $this->floor = $details['Этаж'];
        $this->area = str_replace(',', '.', $details['Площадь ОКС\'a']);
        $this->area_units = $details['Единица измерения (код)'];
        $this->cadastr_cost = str_replace(',', '.', $details['Кадастровая стоимость']);
        $this->cost_deposit_date = CadastrHelper::normalizeDate($details['Дата внесения стоимости']);
        $this->cost_approval_date = CadastrHelper::normalizeDate($details['Дата утверждения стоимости']);
        $this->valuation_date = CadastrHelper::normalizeDate($details['Дата определения стоимости']);
        $this->address = $details['Адрес (местоположение)'];
        $this->oks = $details['(ОКС) Тип'];
        $this->info_update_date = CadastrHelper::normalizeDate($details['Дата обновления информации']);
        $this->encoded_object = $response['encoded_object'];
        $this->saveOrder();
        $this->confirm_code = $this->getTransactionInfo();

        return $this->save();
    }

    public function saveOrder()
    {
        $client = new Client();
        $response = $client->createRequest()->setMethod('post')
            ->setData(['encoded_object' => $this->encoded_object, 'documents' => ['XZP']])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/cadaster/save_order')
            ->send()->getData();

        $this->transaction_id = $response['transaction_id'];
        $this->document_id = $response['documents_id']['XZP'];
    }

    public function getTransactionInfo()
    {
        $client = new Client();
        $response = $client->createRequest()->setMethod('post')
            ->setData(['id' => $this->transaction_id])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/transaction/info')
            ->send()->getData();
        return $response['pay_methods']['free']['confirm_code'];
    }

    public function pay()
    {
        $client = new Client();
        $response = $client->createRequest()->setMethod('post')
            ->setData(['id' => $this->transaction_id, 'confirm' => $this->confirm_code])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/transaction/pay')
            ->send()->getData();

        return $response['paid'];
    }

    private function getObjectInfo()
    {
        $client = new Client();
        return $client->createRequest()->setMethod('post')
            ->setData(['query' => $this->cadastr_number])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/cadaster/objectInfoFull')
            ->send()->getData();
    }

    public function loadDocument()
    {
        if (!$this->isDocumentReady()) {
            return false;
        }

        $client = new Client();
        $response = $client->createRequest()->setMethod('post')
            ->setData(['document_id' => $this->document_id, 'format' => 'HTML'])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/cadaster/download')
            ->send()->getContent();

        $this->document = $response;
        $this->status = RealEstateCadastr::STATUS_COMPLETED;
        return $this->save();
    }

    private function isDocumentReady()
    {
        $client = new Client();
        $response = $client->createRequest()->setMethod('post')
            ->setData(['id' => $this->transaction_id])
            ->setHeaders(['Token' => 'JRF3-HGN8-HHFO-88SW'])
            ->setUrl('https://apirosreestr.ru/api/cadaster/orders')
            ->send()->getData();
        return $response['documents'][0]['date_complete'];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\RealEstateCadastrQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RealEstateCadastrQuery(get_called_class());
    }
}
