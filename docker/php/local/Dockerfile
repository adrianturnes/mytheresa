FROM adrianturnes/my-theresa-base:8.4-1.0

ARG TARGETPLATFORM
ARG BUILDPLATFORM
ARG XDEBUG_CLIENT_HOST

RUN echo "Running on $BUILDPLATFORM, building for $TARGETPLATFORM"

RUN echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN export PATH="$PATH:/root/.composer/vendor/bin"
