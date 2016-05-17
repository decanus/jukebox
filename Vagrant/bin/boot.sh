#!/usr/bin/env sh

PATH=$PATH:/usr/local/bin

service nginx start
service php-fpm start
service redis start
service mongod start

cd neo4j-community-3.0.1/bin/
sh neo4j start