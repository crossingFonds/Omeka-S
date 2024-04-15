FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
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
        curl \
        ghostscript \
        poppler-utils \
        libsodium-dev \
        libicu-dev \
        nano \
        libvips-tools \
        apt-utils \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && a2enmod rewrite headers \
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql mysqli gd intl \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add the Omeka-S PHP code
# Latest Omeka version, check: https://omeka.org/s/download/
ENV OMEKA_VERSION 4.0.4
RUN curl -L "https://github.com/omeka/omeka-s/releases/download/v${OMEKA_VERSION}/omeka-s-${OMEKA_VERSION}.zip" -o /var/www/omeka-${OMEKA_VERSION}.zip \
    && unzip /var/www/omeka-${OMEKA_VERSION}.zip -d /var/www/ \
    && rm -Rf /var/www/omeka-${OMEKA_VERSION}.zip /var/www/html \
    && mv /var/www/omeka-s/ /var/www/html

# default service settings
COPY docker/docker-entrypoint.sh /docker-entrypoint.sh
COPY docker/imagemagick-policy.xml /etc/ImageMagick-6/policy.xml
COPY docker/.htaccess /var/www/html/.htaccess
COPY docker/php.ini /usr/local/etc/php/conf.d/omeka.ini

# omeka settings
COPY --chown=www-data:www-data --chmod=771 themes /var/www/html/themes/
COPY --chown=www-data:www-data --chmod=771 modules /var/www/html/modules/

RUN chown www-data:www-data -R /var/www/html/themes/ /var/www/html/modules/ \
    && chmod 771 -R /var/www/html/themes/ /var/www/html/modules/

CMD ["/docker-entrypoint.sh"]