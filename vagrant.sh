#!/usr/bin/env bash

if [ -f "/var/vagrant_provision" ]; then
	exit 0
fi

_timezone='America/Sao_Paulo'
_hostname='Espalda-PHP'

echo $_timezone > /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

echo $_hostname > /etc/hostname

echo "###################"
echo "# UPDATING SYSTEM #"
echo "###################"

apt-get update
apt-get install -y curl graphviz php5-cli php5-xsl php-pear git lighttpd


echo "#######################"
echo "# INSTALLING COMPOSER #"
echo "#######################"

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "###################"
echo "# INSTALLING ROBO #"
echo "###################"

wget http://robo.li/robo.phar
chmod +x robo.phar
mv robo.phar /usr//bin/robo

echo "########################"
echo "# CONFIGURING LIGHTTPD #"
echo "########################"

rm -rfv /var/www
ln -s /vagrant /var/www

touch /var/vagrant_provision