FROM php:8.4.5-fpm-bullseye

ARG TARGETPLATFORM
ARG BUILDPLATFORM
ARG COMPOSER_VERSION=2.8.1
ARG XDEBUG_CLIENT_HOST
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN echo "Running on $BUILDPLATFORM, building for $TARGETPLATFORM"

WORKDIR "/var/www"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        unzip \
        libzip-dev \
        libpng-dev

RUN docker-php-ext-install bcmath gd pdo_mysql zip

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY .. /var/www

EXPOSE 9000

CMD ["php-fpm"]

# Install Composer
RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION}
RUN export PATH="$PATH:$HOME/.composer/vendor/bin"

RUN usermod -u 1000 www-data
RUN usermod -a -G www-data root
RUN mkdir -p /var/www
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug