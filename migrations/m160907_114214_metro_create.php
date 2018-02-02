<?php

use yii\db\Migration;
use yii\db\Schema;

class m160907_114214_metro_create extends Migration
{
    public $tableName = '{{%metro}}';
    public $defaultStations = ["Авиамоторная", "Автозаводская", "Академическая", "Александровский сад", "Алексеевская", "Алма-Атинская", "Алтуфьево", "Аннино", "Арбатская (Арбатско-Покровская линия)", "Арбатская (Филевская линия)", "Аэропорт", "Бабушкинская", "Багратионовская", "Баррикадная", "Бауманская", "Беговая", "Белорусская", "Беляево", "Бибирево", "Библиотека имени Ленина", "Борисово", "Боровицкая", "Ботанический сад", "Братиславская", "Бульвар адмирала Ушакова", "Бульвар Дмитрия Донского", "Бульвар Рокоссовского", "Бунинская аллея", "Варшавская", "ВДНХ", "Владыкино", "Водный стадион", "Войковская", "Волгоградский проспект", "Волжская", "Волоколамская", "Воробьевы горы", "Выставочная", "Выхино", "Деловой центр", "Динамо", "Дмитровская", "Добрынинская", "Домодедовская", "Достоевская", "Дубровка", "Жулебино", "Зябликово", "Измайловская", "Калужская", "Кантемировская", "Каховская", "Каширская", "Киевская", "Китай-город", "Кожуховская", "Коломенская", "Комсомольская", "Коньково", "Красногвардейская", "Краснопресненская", "Красносельская", "Красные ворота", "Крестьянская застава", "Кропоткинская", "Крылатское", "Кузнецкий мост", "Кузьминки", "Кунцевская", "Курская", "Кутузовская", "Ленинский проспект", "Лермонтовский проспект", "Лубянка", "Люблино", "Марксистская", "Марьина роща", "Марьино", "Маяковская", "Медведково", "Международная", "Менделеевская", "Митино", "Молодежная", "Монорельса Выставочный центр", "Монорельса Телецентр", "Монорельса Улица Академика Королева", "Монорельса Улица Милашенкова", "Монорельса Улица Сергея Эйзенштейна", "Монорельсовой дороги Тимирязевская", "Мякинино", "Нагатинская", "Нагорная", "Нахимовский проспект", "Новогиреево", "Новокосино", "Новокузнецкая", "Новослободская", "Новоясеневская", "Новые Черемушки", "Октябрьская", "Октябрьское поле", "Орехово", "Отрадное", "Охотныйряд", "Павелецкая", "Парк культуры", "Парк Победы", "Партизанская", "Первомайская", "Перово", "Петровско-Разумовская", "Печатники", "Пионерская", "Планерная", "Площадь Ильича", "Площадь Революции", "Полежаевская", "Полянка", "Пражская", "Преображенская площадь", "Пролетарская", "Проспект Вернадского", "Проспект Мира", "Профсоюзная", "Пушкинская", "Пятницкое шоссе", "Речной вокзал", "Рижская", "Римская", "Рязанский проспект", "Савеловская", "Свиблово", "Севастопольская", "Семеновская", "Серпуховская", "Славянский бульвар", "Смоленская (Арбатско-Покровская линия)", "Смоленская (Филевская линия)", "Сокол", "Сокольники", "Спартак", "Спортивная", "Сретенский бульвар", "Строгино", "Студенческая", "Сухаревская", "Сходненская", "Таганская", "Тверская", "Театральная", "Текстильщики", "Теплый стан", "Тимирязевская", "Третьяковская", "Тропарево", "Трубная", "Тульская", "Тургеневская", "Тушинская", "Улица Академика Янгеля", "Улица Горчакова", "Улица Скобелевская", "Улица Старокачаловская", "Улица 1905 года", "Университет", "Филевский парк", "Фили", "Фрунзенская", "Царицыно", "Цветной бульвар", "Черкизовская", "Чертановская", "Чеховская", "Чистые пруды", "Чкаловская", "Шаболовская", "Шипиловская", "Шоссе Энтузиастов", "Щелковская", "Щукинская", "Электрозаводская", "Юго-Западная", "Южная", "Ясенево",];

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_TEXT,
        ]);
        foreach ($this->defaultStations as $station) {
            $this->insert($this->tableName, [
                'name' => $station
            ]);
        }
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

}