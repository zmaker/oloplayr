#!/usr/bin/env bash

echo -e "\n--- Install base packages ---\n"
apt-get -y install vim mc curl nano build-essential git > /dev/null 2>&1

echo -e "\n--- Updating packages list ---\n"
apt-get -qq update

echo -e "\n--- Installing PHP-specific packages ---\n"
apt-get -y install php5 apache2 libapache2-mod-php5 php5-curl php5-gd php5-mcrypt php-apc > /dev/null 2>&1
apt-get -y install sqlite3 libsqlite3-dev /dev/null 2>&1

if ! [ -L /var/www ]; then
    rm -rf /var/www
    ln -fs /website /var/www
fi

echo -e "\n--- Enabling mod-rewrite ---\n"
a2enmod rewrite > /dev/null 2>&1

echo -e "\n--- Allowing Apache override to all ---\n"
sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

echo -e "\n--- We definitly need to see the PHP errors, turning them on ---\n"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini

echo -e "\n--- Restarting Apache ---\n"
service apache2 restart > /dev/null 2>&1

apt-get -y install php5-sqlite

service apache2 restart 

#echo -e "\n--- Installing NodeJS and NPM ---\n"
#apt-get -y install nodejs > /dev/null 2>&1
#curl --silent https://npmjs.org/install.sh | sh > /dev/null 2>&1

#echo -e "\n--- Installing javascript components ---\n"
#npm install -g gulp bower > /dev/null 2>&1

#echo -e "\n--- Updating project components and pulling latest versions ---\n"
#cd /vagrant
#sudo -u vagrant -H sh -c "composer install" > /dev/null 2>&1
#cd /vagrant/client
#sudo -u vagrant -H sh -c "npm install" > /dev/null 2>&1
#sudo -u vagrant -H sh -c "bower install -s" > /dev/null 2>&1
#sudo -u vagrant -H sh -c "gulp" > /dev/null 2>&1
