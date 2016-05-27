#!/usr/bin/env sh

PATH=$PATH:/usr/local/bin

service nginx start
service php-fpm start
service redis start
service mongod start
service postgresql start
systemctl start elasticsearch.service
