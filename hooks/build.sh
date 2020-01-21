#!/bin/sh
# https://github.com/attach-live/attach-documentation/wiki/Versioning

# fail on error
set -e

# name arguments
BRANCH_NAME=$1

# set version
case $BRANCH_NAME in dev*)
  # hardcoded
  MAJOR="1"
  # dev-m3 -> 3
  # dev -> 0
  MINOR="$(node -p "const minor = '"$BRANCH_NAME"'.split('-')[1]; minor ? minor.slice(1) : 0")"
  # hardcoded
  PATCH="0"

  # TODO: set SVN version
esac


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

  # TODO: set SVN version
esac

# TODO: svn build and / or publish
