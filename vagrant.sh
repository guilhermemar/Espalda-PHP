#!/usr/bin/env bash

if [ -f "/var/vagrant_provision" ]; then
	exit 0
fi

echo "America/Sao_Paulo" > /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

apt-get update
apt-get install -y curl php5-cli php5-xsl php-pear

###### INSTALLING AND CONFIGURING PHING ######

echo "####################"
echo "# INSTALLING PHING #"
echo "####################"

pear channel-discover pear.phing.info
pear install phing/phing

###### INSTALLING AND CONFIGURING PHPUNIT ######

echo "######################"
echo "# INSTALLING PHPUNIT #"
echo "######################"

pear config-set auto_discover 1
pear install pear.phpunit.de/PHPUnit

###### INSTALLING AND CONFIGURING PHPDOCUMENTOR ######

echo "############################"
echo "# INSTALLING PHPDOCUMENTOR #"
echo "############################"

pear channel-discover pear.phpdoc.org
pear install phpdoc/phpDocumentor

touch /var/vagrant_provision