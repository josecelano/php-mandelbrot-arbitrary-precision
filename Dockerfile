FROM php:7.4-cli

# Git and unzip extensions needed by composer
# 'bc' command needed to calculate some math funtions from console
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && apt-get install -y git unzip \
    && apt-get install -y bc

# Install PHP extensions installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions gd zip decimal

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

WORKDIR /usr/src/app

CMD [ "./vendor/bin/phpunit" ]