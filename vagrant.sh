#!/usr/bin/env bash

if [ -f "/var/vagrant_provision" ]; then
	exit 0
fi

echo "America/Sao_Paulo" > /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

apt-get update
apt-get install -y curl php5-cli php5-xsl

###### INSTALLING AND CONFIGURING COMPOSER ######

echo "#######################"
echo "# INSTALLING COMPOSER #"
echo "#######################"

curl -s http://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "In reality you can only need use "composer" command"

touch /var/vagrant_provision

###### legace code ######
#apt-get install -y apache2 php5 php5-cli curl
#apt-get install -y php5 phpunit
#rm -rf /var/www
#ln -fs /vagrant /var/www
