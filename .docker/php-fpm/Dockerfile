FROM php:7-fpm

# fish
RUN FISH_VERSION="3.0.2" \
    && apt-get update \
    && apt-get install -y libncurses5-dev \
    && curl -OSLs "https://github.com/fish-shell/fish-shell/releases/download/$FISH_VERSION/fish-$FISH_VERSION.tar.gz" \
    && tar -xzf "fish-$FISH_VERSION.tar.gz" \
    && cd "fish-$FISH_VERSION" \
    && ./configure \
    && make \
    && make install \
    && cd / \
    && rm -rf "fish-$FISH_VERSION" "fish-$FISH_VERSION.tar.gz" \
    && fish -c true
RUN mkdir -p /var/www/.config/fish \
    && chown -R www-data:www-data /var/www/.config/fish \
    && mkdir -p /var/www/.local/share/fish \
    && chown -R www-data:www-data /var/www/.local/share/fish

RUN apt-get update \
    && apt-get install -y git libzip-dev zlib1g-dev unzip

# core extensions
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install zip

# intl
RUN apt-get update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install intl

# pdo_pgsql
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# memcached
RUN apt-get update \
    && apt-get install -y libmemcached-dev zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

# gd
RUN apt-get update \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# imagick
RUN apt-get update \
    && apt-get install -y --no-install-recommends libmagickwand-dev imagemagick \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# xdebug
# we do not enable by default the extension
# this can be done in php/php-ini-overrides.ini when needed in order improve performance when not debuging
RUN pecl install xdebug-2.9.0

# composer
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_HOME /var/www/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo
RUN chown -R www-data:www-data $COMPOSER_HOME
ENV PATH "${PATH}:/var/www/composer/vendor/bin"

RUN usermod -u 1000 www-data

EXPOSE 9000
WORKDIR /var/www
