Arenda
============================

Требования
-------------------
 - PHP 5.6
 - PostgreSQL


Установка
-------------------

    git clone https://github.com/muxtor/arenda arenda"
    cd arenda
    composer global require "fxp/composer-asset-plugin:~1.1.1
    composer install
    cp config/db.example.php config/db.php
    createuser -s -r postgres
    php yii migrate
    
   Для авторизации используте логин muxtorsoft@mail.ru и пароль 123qwe