#!/bin/sh
# https://github.com/attach-live/attach-documentation/wiki/Versioning

# fail on error
set -e

# name arguments
BRANCH_NAME=$1

case $BRANCH_NAME in prod*)
  # hardcoded
  MAJOR="1"
  # prod-m3-timestamp -> 3
  MINOR="$(node -p "'"$BRANCH_NAME"'.split('-')[1].slice(1)")"
  # prod-m3-timestamp -> timestamp
  PATCH="$(node -p "'"$BRANCH_NAME"'.split('-')[2]")"
  # prod-m3-timestamp-hotfix -> -hotfix
  # prod-m3-timestamp -> ''
  SUFFIX="$(node -p "const suffix = '"$BRANCH_NAME"'.split('-')[3]; suffix ? '-' + suffix : ''")"
  TIMESTAMP="$(node -p "Date.now()")"

  VERSION="$MAJOR.$MINOR.$PATCH-$TIMESTAMP$SUFFIX"

  # pull
  apt-get update && apt-get install -y subversion ca-certificates
  svn co $SVN_URL attach-embeds-remote

  # compare
  REMOTE_VERSION="$(ls ./attach-embeds-remote/tags | cut -f1 -d'/' | sort | tail -n 1)"
  sed -i "s/0.0.0/$REMOTE_VERSION/g" ./attach-embeds/attach-embeds.php
  DIFFERS="$(diff -rq attach-embeds attach-embeds-remote/tags/$REMOTE_VERSION)"

  if [ -z "$DIFFERS" ]; then
    # set version
    sed -i "s/$REMOTE_VERSION/$VERSION/g" ./attach-embeds/attach-embeds.php

    # publish
    cp -rf attach-embeds attach-embeds-remote/tags/$VERSION
    cd attach-embeds-remote
    svn add tags/*
    svn ci -m "Version $VERSION" --no-auth-cache --username $SVN_USERNAME --password $SVN_PASSWORD
  else
    # log and exit
    echo "Not publishing attach-embeds-wordpress because compared to the remote, no code has changed"
    exit 0
  fi
esac
