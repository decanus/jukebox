#!/usr/bin/env sh

PATH=$PATH:/usr/local/bin

systemctl start nginx.service
systemctl start php-fpm.service
systemctl start redis.service
systemctl start mongod.service
systemctl start postgresql.service
systemctl start elasticsearch.service
systemctl start jn-mirror-socket.service
