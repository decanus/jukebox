#!/bin/sh

DIR=$(dirname $0)

node "${DIR}/../index.js" --instance=0 &
node "${DIR}/../index.js" --instance=1 &
node "${DIR}/../index.js" --instance=2 &

wait
