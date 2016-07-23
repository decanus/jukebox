#!/bin/sh

DIR=$(dirname $0)

node "${DIR}/../index.js" --port=8080 &
node "${DIR}/../index.js" --port=8081 &
node "${DIR}/../index.js" --port=8082 &

wait
