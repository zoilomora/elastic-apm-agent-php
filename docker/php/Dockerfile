FROM php:5.4-cli

RUN apt update && \
    apt install -y \
        unzip && \
    docker-php-ext-install \
        mbstring && \
    pecl install xdebug-2.4.1 && \
    docker-php-ext-enable \
        xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

ENV PATH /var/app/bin:/var/app/vendor/bin:$PATH

WORKDIR /var/app
