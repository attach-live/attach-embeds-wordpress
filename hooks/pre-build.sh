#!/bin/sh

# fail on error
set -e

# name arguments
BRANCH_NAME=$1

# download
case $BRANCH_NAME in dev*)
  wget --user $LOCO_KEY --password $LOCO_KEY -O mo.uip localise.biz/api/export/archive/mo.zip?fallback=en
  wget --user $LOCO_KEY --password $LOCO_KEY -O po.uip localise.biz/api/export/archive/po.zip
esac

case $BRANCH_NAME in prod*)
  wget --user $LOCO_KEY --password $LOCO_KEY -O mo.uip localise.biz/api/export/archive/mo.zip
  wget --user $LOCO_KEY --password $LOCO_KEY -O po.uip localise.biz/api/export/archive/po.zip
esac

# unzip
apt-get update && apt-get install -y unzip
unzip mo.zip -d mo
unzip po.zip -d po

# extract
npm install -g po2json@0.4.5
npm link po2json
node ./hooks/extract-locales.js $BRANCH_NAME
