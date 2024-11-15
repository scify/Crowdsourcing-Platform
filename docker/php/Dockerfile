FROM php:8.3-fpm

# Copy configuration files
COPY php.ini /usr/local/etc/php/
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY .bashrc /root/

# Set environment variables
ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

# Install dependencies
RUN apt-get update \
  && apt-get install -y build-essential zlib1g-dev default-mysql-client curl gnupg procps vim git unzip libzip-dev libpq-dev \
  && docker-php-ext-install zip pdo_mysql pdo_pgsql pgsql

# intl
RUN apt-get install -y libicu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl

# gd
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
docker-php-ext-install gd

# redis
RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql

# Xdebug
# Xdebug Installation
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Xdebug Configuration
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
RUN composer config --global process-timeout 3600
RUN composer global require "laravel/installer"

ENV NODE_VERSION=18.19.0

ENV NVM_DIR=/usr/local/.nvm
RUN mkdir "$NVM_DIR"
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="$NVM_DIR/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version

# Create laravel caching folders
RUN mkdir -p /var/www/storage/framework /var/www/storage/framework/cache \
    /var/www/storage/framework/testing /var/www/storage/framework/sessions \
    /var/www/storage/framework/views

RUN mkdir -p /var/www/storage /var/www/storage/logs /var/www/storage/framework \
    /var/www/storage/framework/sessions /var/www/bootstrap/cache /var/www/storage/app/uploads/cv_files

# Fix files ownership
RUN chown -R www-data /var/www/storage
RUN chown -R www-data /var/www/storage/framework
RUN chown -R www-data /var/www/storage/framework/sessions
RUN chown -R www-data /var/www/bootstrap
RUN chown -R www-data /var/www/bootstrap/cache

# Set correct permissions
RUN chmod -R 755 /var/www/storage
RUN chmod -R 755 /var/www/storage/logs
RUN chmod -R 755 /var/www/storage/framework
RUN chmod -R 755 /var/www/storage/framework/sessions
RUN chmod -R 755 /var/www/bootstrap

RUN chown -R www-data:www-data /var/www

WORKDIR /root
RUN git clone https://github.com/seebi/dircolors-solarized

# Expose ports for Laravel and Vite
EXPOSE 80 3000 5173
WORKDIR /var/www