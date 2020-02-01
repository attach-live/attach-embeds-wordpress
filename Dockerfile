FROM wordpress:5.3.2-php7.2-apache

RUN apt-get update && apt-get install -y wget unzip \
  && wget -O /var/es_ES.zip https://downloads.wordpress.org/translation/core/5.3.2/es_ES.zip \
  && wget -O /var/de_DE.zip https://downloads.wordpress.org/translation/core/5.3.2/de_DE.zip \
  && mkdir -p /var/www/html/wp-content/languages/ \
  && unzip /var/es_ES.zip -d /var/www/html/wp-content/languages/ \
  && unzip /var/de_DE.zip -d /var/www/html/wp-content/languages/

COPY attach-embeds /var/www/html/wp-content/plugins/
