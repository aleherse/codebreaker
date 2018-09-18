FROM php:7.2-fpm

# Install software
RUN apt-get update && apt-get install -yq git vim zip && \
    docker-php-ext-install pdo_mysql && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
RUN curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://raw.githubusercontent.com/composer/getcomposer.org/b107d959a5924af895807021fcef4ffec5a76aa9/web/installer \
 && php -r " \
    \$signature = '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061'; \
    \$hash = hash('SHA384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
        unlink('/tmp/installer.php'); \
        echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
        exit(1); \
    }" \
 && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer \
 && composer --ansi --version --no-interaction \
 && rm -rf /tmp/* /tmp/.htaccess

# configure PHP and debugging command
COPY php.ini /usr/local/etc/php/conf.d/
COPY debug.sh /usr/local/bin/debug
RUN chmod +x /usr/local/bin/debug

WORKDIR /app
VOLUME /app

EXPOSE 9000

CMD ["php-fpm", "-F"]
