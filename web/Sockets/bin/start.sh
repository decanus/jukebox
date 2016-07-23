#!/bin/sh

DIR=$(dirname $0)

node "${DIR}/../index.js" --port=8080 --instance=1 &
node "${DIR}/../index.js" --port=8081 --socketId=2 &
node "${DIR}/../index.js" --port=8082 --socketId=3 &

wait
