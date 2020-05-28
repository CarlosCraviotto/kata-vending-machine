FROM php:7.3.6-fpm-alpine
WORKDIR /app

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev \
    && pecl install apcu-5.1.17 \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        intl \
    && docker-php-ext-enable \
        apcu

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY etc/infrastructure/php/ /usr/local/etc/php/
