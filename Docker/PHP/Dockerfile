  
FROM php:7.4-fpm

# Surpresses debconf complaints of trying to install apt packages interactively
# https://github.com/moby/moby/issues/4032#issuecomment-192327844
 
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils build-essential libpng-dev libjpeg-dev libxml2-dev libmcrypt-dev \
    libcurl4-gnutls-dev zlib1g-dev libicu-dev libedit-dev \
    libncurses5-dev libtidy-dev libzip-dev msmtp msmtp-mta git curl zip openssl && \
    apt-get -y autoremove && apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Pear Extensions
RUN pecl install xdebug mcrypt && \
    docker-php-ext-enable xdebug mcrypt

# Other PHP7 Extensions
RUN docker-php-ext-install -j"$(nproc)" intl mysqli zip tidy opcache \
    pdo pdo_mysql xml xmlrpc curl json readline bcmath iconv

CMD ["php-fpm"]