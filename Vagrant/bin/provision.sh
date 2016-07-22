#!/usr/bin/env bash

sudo yum install -y epel-release

sudo getent group php >/dev/null || groupadd -r php
sudo getent passwd php >/dev/null || useradd -r -s /sbin/nologin -d /var/www -c"php-fpm user" -g php php

wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
sudo rpm -Uvh remi-release-7*.rpm


sudo yum clean all
sudo yum install -y php70 php-cli php-dom php-xsl php-mbstring php-mssql php-gd php-pecl-imagick php-tidy php-soap php-mysqlnd php-dom php-pdo php-devel php-pear php-redis php-fpm php-pgsql --enablerepo remi-php70
sudo yum install -y nginx redis gcc gcc-c++ openssl-devel

rm /etc/hosts
ln -s /vagrant/conf/hosts /etc/hosts

yum install -y postgresql-server postgresql-contrib
postgresql-setup initdb

systemctl start postgresql
systemctl enable postgresql

sudo su - postgres -c "psql -a -w -f /var/www/packages/database.sql"
sudo su - postgres -c "psql -t jukebox -a -w -f /var/www/packages/tables.sql"

rm /var/lib/pgsql/data/pg_hba.conf
ln -s /vagrant/conf/postgres.conf /var/lib/pgsql/data/pg_hba.conf

# Elasticsearch
yum install -y java-1.8.0-openjdk.x86_64
wget https://download.elasticsearch.org/elasticsearch/release/org/elasticsearch/distribution/rpm/elasticsearch/5.0.0-alpha2/elasticsearch-5.0.0-alpha2.rpm
rpm -ivh elasticsearch*.rpm

rm -rf /etc/elasticsearch
ln -s /vagrant/conf/elasticsearch /etc/elasticsearch

systemctl enable elasticsearch.service

sudo ln -s /var/www/packages/configs/dev/api.jukebox.ninja.conf /etc/nginx/conf.d/api.jukebox.ninja.conf
sudo ln -s /var/www/packages/configs/dev/jukebox.ninja.conf /etc/nginx/conf.d/jukebox.ninja.conf

rm /etc/php.ini
sudo ln -s /vagrant/conf/php.ini /etc/php.ini

touch /vagrant/provisioned

echo "Provisioning done! Please create a file called 'provisioned' and run 'vagrant reload'"
