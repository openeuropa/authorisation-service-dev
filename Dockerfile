FROM composer:1.7 AS build
WORKDIR /app

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY RoboFile.php RoboFile.php
COPY robo.yml robo.yml

RUN composer --no-interaction install

FROM apache/syncope:2.1.1

RUN apt-get update && apt-get install -qq -y wget curl php7.0

COPY --from=build /app .
