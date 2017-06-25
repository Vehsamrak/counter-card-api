FROM ubuntu:16.04
MAINTAINER Petr Karmashev <smonkl@bk.ru>

ENV DEBIAN_FRONTEND noninteractive

COPY app/docker/etc/apt /etc/apt

RUN apt-get update && \
    apt-get install -y --allow-unauthenticated \
    git \
    curl \
    nginx \
    php7.1-cli \
    php7.1-curl \
    php7.1-fpm \
    php7.1-mysql \
    php7.1-sqlite3 \
    php7.1-xml \
    php7.1-mbstring

RUN apt-get clean && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/*
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
RUN curl -o /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar && \
    chmod +x /usr/local/bin/phpunit

COPY app/docker/etc /etc

CMD ["bash", "/project/app/docker/init.sh"]

EXPOSE 80
