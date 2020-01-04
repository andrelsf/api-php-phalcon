FROM    php:7.2-apache

ENV     APP_DIR=/usr/src/app/
ENV     APP_DIR_DATA=/usr/src/app/var/cache/
ENV     APP_DIR_LOGS=/usr/src/app/var/logs/
#ENV     APP_USER=app

RUN     apt-get update \
        && apt-get install -y git \
        && cd /opt/ \
        && git clone https://github.com/jbboehr/php-psr.git \
        && cd php-psr && phpize && ./configure \
        && make && make test && make install \
        && echo "extension=psr.so" > /usr/local/etc/php/conf.d/php-psr.ini \
        && cd /opt/ \
        && git clone --depth=1 "git://github.com/phalcon/cphalcon.git" \
        && cd cphalcon/build && ./install \
        && echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini


RUN     docker-php-ext-install pdo pdo_mysql \
        && a2enmod rewrite \
        && service apache2 restart \
        && mkdir -p ${APP_DIR} \
        && mkdir -p ${APP_DIR_DATA} \
        && mkdir -p ${APP_DIR_LOGS}

#RUN     useradd -M -s /bin/bash ${APP_USER} \
#        && chown ${APP_USER}. ${APP_DIR} -R \
#        && chown 33.33 ${APP_DIR_DATA} -R \
#        && chown 33.33 ${APP_DIR_LOGS} -R

ADD     ./app.default.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE  80

WORKDIR /usr/src/app/
