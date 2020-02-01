#!/bin/sh

# fail on error
set -e

# copy languages
cp -r /var/languages/. /var/www/html/wp-content/languages/

# run
exec apache2-foreground
