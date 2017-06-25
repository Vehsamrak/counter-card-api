FROM ubuntu:14.04
MAINTAINER Petr Karmashev <smonkl@bk.ru>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get install -y --force-yes \
    git \
    curl \
    nginx \
    php7.1-cli \
    php7.1-curl \
    php7.1-fpm \
    php7.1-mysql \
    php7.1-sqlite3

RUN apt-get clean && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/*
RUN curl -sS https://getcomposer.org/installer | php

COPY app/docker/etc /etc
COPY app/docker/init.sh /init.sh

CMD ["bash", "init.sh"]

EXPOSE 80
