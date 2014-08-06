#!/usr/bin/env bash

if [ -f "/var/vagrant_provision" ]; then
	exit 0
fi

echo "America/Sao_Paulo" > /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

echo "###################"
echo "# UPDATING SYSTEM #"
echo "###################"

apt-get update
apt-get install -y curl graphviz php5-cli php5-xsl php-pear git lighttpd

###### INSTALLING AND CONFIGURING COMPOSER ######

echo "#######################"
echo "# INSTALLING COMPOSER #"
echo "#######################"

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

###### INSTALLING AND CONFIGURING PHING ######

echo "####################"
echo "# INSTALLING PHING #"
echo "####################"

pear channel-discover pear.phing.info
pear install phing/phing

echo "########################"
echo "# CONFIGURING LIGHTTPD #"
echo "########################"

rm -rfv /var/www
ln -s /vagrant /var/www

touch /var/vagrant_provision