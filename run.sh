#!/bin/sh

# fail on error
set -e

# copy languages
cp -r /var/languages/. /var/www/html/wp-content/languages/

# copy themes
cp -r /var/themes/. /var/www/html/wp-content/themes/

# run
exec docker-entrypoint.sh apache2-foreground
