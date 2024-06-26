FROM php:8.2-apache-bookworm AS omeka

# Omeka-S web publishing platform for digital heritage collections (https://omeka.org/s/)
# Previous maintainers: Oldrich Vykydal (o1da) - Klokan Technologies GmbH  / Eric Dodemont <eric.dodemont@skynet.be> // Giorgio Comai <g@giorgiocomai.eu>
# Modified for use by the Crossing Fonds project

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get -qq update \
    && apt-get -qq -y upgrade \
    && apt-get -qq -y --no-install-recommends install \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libjpeg-dev \
        libmemcached-dev \
        zlib1g-dev \
        imagemagick \
        libmagickwand-dev \
        wget \
        ghostscript \
        poppler-utils \
        libsodium-dev \
        libicu-dev \
        nano \
        libvips-tools \
        sendmail \
    && rm -rf /var/lib/apt/lists/* \
    && a2enmod rewrite headers \
# Install the PHP extensions we need
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ \
    && docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql mysqli gd \
    && yes | pecl install imagick && docker-php-ext-enable imagick \
# Support for more languages, e.g. for date formatting and month names
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Add the Omeka-S PHP code
# Latest Omeka version, check: https://omeka.org/s/download/
RUN wget --no-verbose "https://github.com/omeka/omeka-s/releases/download/v4.0.4/omeka-s-4.0.4.zip" -O /var/www/latest_omeka_s.zip \
    && unzip -q /var/www/latest_omeka_s.zip -d /var/www/ \
    && rm /var/www/latest_omeka_s.zip \
    && rm -rf /var/www/html/ \
    && mv /var/www/omeka-s/ /var/www/html/

COPY docker/docker-entrypoint.sh /docker-entrypoint.sh
COPY docker/imagemagick-policy.xml /etc/ImageMagick-6/policy.xml
COPY docker/.htaccess /var/www/html/.htaccess
COPY docker/php.ini /usr/local/etc/php/conf.d/omeka.ini
COPY docker/sendmail.ini /usr/local/etc/php/conf.d/sendmail.ini
COPY --chown=www-data:www-data --chmod=771 themes /var/www/html/themes/
COPY --chown=www-data:www-data --chmod=771 modules /var/www/html/modules/

RUN chown www-data:www-data -R /var/www/html/themes/ /var/www/html/modules/ \
    && chmod 771 -R /var/www/html/themes/ /var/www/html/modules/

VOLUME /var/www/html

CMD ["/docker-entrypoint.sh"]