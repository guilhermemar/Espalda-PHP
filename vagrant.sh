#!/usr/bin/env bash

apt-get update
apt-get install -y apache2 php5 php5-cli curl
#apt-get install -y php5 phpunit
rm -rf /var/www
ln -fs /vagrant /var/www
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
