FROM php:7.3-fpm-alpine3.10@sha256:27f59d5dd6c22a2ff8b394bd42737962fa99ca0a195fa7de34927350a67dca4a

RUN apk add --no-cache autoconf g++ gcc make --virtual .build-deps \
    && docker-php-source extract \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-source delete \
    && apk del --purge .build-deps
