APP_NAME=$1
PG_PASSWORD=$2

echo '**********************************************************************************************************************************************'
echo '* - Deploy: '$APP_NAME
echo '**********************************************************************************************************************************************'



#INSTALL SERVICES
apt-get update
echo '**********************************************************************************************************************************************'
echo '* - install curl: '
echo '**********************************************************************************************************************************************'
apt-get install -y curl

echo '**********************************************************************************************************************************************'
echo '* - install apache: '
echo '**********************************************************************************************************************************************'
apt-get install -y apache2

echo '**********************************************************************************************************************************************'
echo '* - install php: '
echo '**********************************************************************************************************************************************'
apt-get install -y --force-yes software-properties-common
add-apt-repository ppa:ondrej/php
apt-get update
apt-get install -y --force-yes php5.6
service apache2 start
apt-get install -y --force-yes libapache2-mod-php5
sudo apt-get install -y --force-yes php5.6-xml
#apt-get install -y --force-yes mysql-server php5-mysql
apt-get install -y --force-yes zip unzip
apt-get install -y --force-yes php5.6-intl php5-xmlrpc
apt-get update
install -y --force-yes --fix-missing php5.6-imagick
echo '**********************************************************************************************************************************************'
echo '* - install postgres: '
echo '**********************************************************************************************************************************************'
apt-get install -y --force-yes postgresql postgresql-contrib
service postgresql start
apt-get install -y --force-yes libapache2-mod-php5 php5-mcrypt
service postgresql restart
apt-get install -y --force-yes php5.6-pgsql
echo '**********************************************************************************************************************************************'
echo '* - install nano: '
echo '**********************************************************************************************************************************************'
apt-get install -y --force-yes nano
service postgresql restart
apt-get install -y --force-yes php5.6-mbstring
echo '**********************************************************************************************************************************************'
echo '* - install git: '
echo '**********************************************************************************************************************************************'
apt-get install -y git


echo '**********************************************************************************************************************************************'
echo '* - install composer: '
echo '**********************************************************************************************************************************************'
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
composer global require "fxp/composer-asset-plugin:^1.2.0"


echo '**********************************************************************************************************************************************'
echo '* - configure server: '
echo '**********************************************************************************************************************************************'
#CONFIGURE SERVICES
touch "/etc/apache2/sites-available/"$APP_NAME".conf"

#VIRTUAL HOSTS
echo '' > "/etc/apache2/sites-available/000-default.conf"
echo '' > "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '<VirtualHost *:80>' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  ServerName '$APP_NAME >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  ServerAlias www.'$APP_NAME '*.'$APP_NAME >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  ServerAdmin gaftonfifon@yandex.com' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  DocumentRoot /var/www/'$APP_NAME'/web' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  ErrorLog ${APACHE_LOG_DIR}/error.log' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  CustomLog ${APACHE_LOG_DIR}/access.log combined' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  <Directory /var/www/'$APP_NAME'/web>' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '      Options Indexes FollowSymLinks MultiViews' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '      AllowOverride All' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '      Order allow,deny' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '      allow from all' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '  </Directory>' >> "/etc/apache2/sites-available/"$APP_NAME".conf"
echo '</VirtualHost>' >> "/etc/apache2/sites-available/"$APP_NAME".conf"


sed -i 's/peer/trust/g' /etc/postgresql/9.3/main/pg_hba.conf
echo 'host all all      ::1/128      md5' >> /etc/postgresql/9.3/main/pg_hba.conf
echo 'host all postgres 127.0.0.1/32 md5' >> /etc/postgresql/9.3/main/pg_hba.conf
echo 'host all postgres 172.17.0.1/32 md5' >> /etc/postgresql/9.3/main/pg_hba.conf
echo "listen_addresses='*'" >> /etc/postgresql/9.3/main/postgresql.conf
#sudo su - postgres -c "dropdb "$APP_NAME;
sudo su - postgres -c "createdb "$APP_NAME;
sudo su - postgres psql -c "psql -U postgres -d postgres -c \"alter user postgres with password '"$PG_PASSWORD"';\""


#RELOAD SERVICES
a2ensite $APP_NAME
a2enmod rewrite
service postgresql restart
service apache2 restart


echo '**********************************************************************************************************************************************'
echo '* - configure application: '
echo '**********************************************************************************************************************************************'
cd "/var/www/"$APP_NAME"/" && composer install
cd "/var/www/"$APP_NAME"/" && ./yii migrate --interactive=0
cd "/var/www/"$APP_NAME"/web/public/" && mkdir uploads && chmod 777 uploads
cd "/var/www/"$APP_NAME"/web/public/" && chmod 777 img


echo '**********************************************************************************************************************************************'
echo '* - Deplaoy: DONE!!!                                                  '
echo '* - HOST : http://'$APP_NAME' OR http://localhost                     '
echo '* - database : '$APP_NAME'                                            '
echo '* - database password : '$PG_PASSWORD'                                '
echo '* - database port : 5432                                              '
echo '**********************************************************************************************************************************************'