# web-cms

This Docker Image can be used for a nginx proxy.

## Base Docker Image

* [php:7.3.3-apache-stretch](https://hub.docker.com/r/amd64/php/)

## Usage

    docker run -d -p 80:80 -p 443:443 pbecker/web-cms

## Mountable volumes

    Volume: <sites-enabled-dir>:/etc/nginx/sites-enabled
