FROM yiisoftware/yii2-php:7.2-apache

#ARG USER_ID
#ARG GROUP_ID

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/backend/web|g' /etc/apache2/sites-available/000-default.conf

RUN pecl install xdebug-2.7.1 \
        && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y \
    cron \
    rsyslog

COPY cron /etc/cron.d/sample

WORKDIR /app

#RUN groupadd --gid ${USER_ID} www \
#  && useradd --uid ${USER_ID} --gid www --shell /bin/bash --create-home www
#
#USER www

#запускаем процесс apache2
CMD service cron start && service rsyslog start && /usr/sbin/apache2ctl -D FOREGROUND