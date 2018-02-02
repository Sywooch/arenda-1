<?php

use yii\db\Migration;
use app\models\Pages;

class m161209_140041_pages_fill extends Migration
{
	public $tableName = '{{%pages}}';

	public function up()
	{
		$pages = [
			'index'                 => 'Главная',
			'how-it-works'          => 'Как это работает',
			'about-us'              => 'Об Арендатике',
			'contacts'              => 'Контакты',
			'faq'                   => 'Вопросы и ответы',
			'prices'                => 'Особенности и цены',
			'reviews'               => 'Отзывы',
			'online-payment'        => 'Онлайн оплата',
			'online-payment-renter' => 'Онлайн оплата жильцам',
			'data-checking'         => 'Проверка данных',
			'contract'              => 'Договор аренды',
			'screening'             => 'Проверка жильцов',
			'credit-report'         => 'Проверьте кредитную историю кандидата',
			'profile'               => 'Личный профиль',
			'ad'                    => 'Обьявления о недвижимости',
		];

		foreach ($pages as $page => $title) {
			$this->insert($this->tableName, [
				'title'   => $title,
				'content' => file_get_contents(Yii::getAlias('@app/migrations/pages' . '/' . $page . '.php')),
				'url'     => $page,
				'status'  => Pages::STATUS_ACTIVE,
			]);
		}

		return true;
	}

	public function down()
	{
		$this->truncateTable($this->tableName);

		return true;
	}
}
