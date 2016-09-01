FROM php:7-alpine

RUN apk --no-cache add grep postgresql-dev
RUN docker-php-ext-install pdo_pgsql && rm -rf /var/cache/apk
WORKDIR /app
ENV PATH=$PATH:vendor/bin:bin
ENTRYPOINT ["php"]
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY . /app
