FROM php:7.4.9-fpm

ARG UID=1000
ARG GID=1000

COPY php.ini /usr/local/etc/php/

RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# 追加：PHPコンテナとUbuntuのユーザを一致させる
RUN groupadd -g ${GID} appgroup && \
  useradd -u ${UID} -g appgroup -m ichitaro

WORKDIR /var/www
RUN chown -R ${UID}:${GID} /var/www

USER ichitaro