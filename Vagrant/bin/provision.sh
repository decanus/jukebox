#!/usr/bin/env bash

sudo yum install -y epel-release

sudo getent group php >/dev/null || groupadd -r php
sudo getent passwd php >/dev/null || useradd -r -s /sbin/nologin -d /var/www -c"php-fpm user" -g php php

wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
sudo rpm -Uvh remi-release-7*.rpm

wget http://debian.neo4j.org/neotechnology.gpg.key
rpm --import neotechnology.gpg.key

sudo ln -s /vagrant/conf/yum/mongodb.repo /etc/yum.repos.d/mongodb.repo
sudo ln -s /vagrant/conf/yum/neo4j.repo /etc/yum.repos.d/neo4j.repo

sudo yum clean all
sudo yum install -y php70 php-cli php-dom php-xsl php-mbstring php-mssql php-gd php-pecl-imagick php-tidy php-soap php-mysqlnd php-dom php-pdo php-devel php-pear php-redis php-fpm --enablerepo remi-php70
sudo yum install -y nginx redis gcc gcc-c++ openssl-devel mongodb-org neo4j

sudo pecl install mongodb

service mongod start
bash /vagrant/conf/mongo/setup.sh

rm /etc/hosts
ln -s /vagrant/conf/hosts /etc/hosts

sudo ln -s /var/www/packages/configs/dev/api.jukebox.ninja.conf /etc/nginx/conf.d/api.jukebox.ninja.conf

rm /etc/php.ini
sudo ln -s /vagrant/conf/php.ini /etc/php.ini

touch /vagrant/provisioned

echo "Provisioning done! Please create a file called 'provisioned' and run 'vagrant reload'"