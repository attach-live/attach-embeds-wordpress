FROM wordpress:5.3.2-php7.2-apache

# apt
RUN apt-get update && apt-get install -y wget unzip \
  && rm -rf /var/lib/apt/lists/*

# translations
RUN wget -O /var/es_ES.zip https://downloads.wordpress.org/translation/core/5.3.2/es_ES.zip \
  && wget -O /var/de_DE.zip https://downloads.wordpress.org/translation/core/5.3.2/de_DE.zip \
  && mkdir -p /var/www/html/wp-content/languages/ \
  && unzip /var/es_ES.zip -d /var/languages/ \
  && unzip /var/de_DE.zip -d /var/languages/ \
  && rm /var/es_ES.zip \
  && rm /var/de_DE.zip

# themes
RUN wget -O /var/colormag.zip https://downloads.wordpress.org/theme/colormag.1.4.4.zip \
  && mkdir -p /var/www/html/wp-content/themes/ \
  && unzip /var/colormag.zip -d /var/themes/ \
  && rm /var/colormag.zip

# plugins
COPY attach-embeds /var/www/html/wp-content/plugins/

# run
COPY run.sh /var/run.sh
RUN chmod +x /var/run.sh
CMD ["/var/run.sh"]
