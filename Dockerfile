FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    linux-headers \
    libxml2-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-install ftp soap

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app