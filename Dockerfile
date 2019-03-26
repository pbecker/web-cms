# Pull php base image with apache
FROM php:7.3.3-apache-stretch

RUN \
  apt-get update && \
  mkdir /opt/weblication

# FROM php:7.2-cli
COPY wSetup.php /opt/weblication
WORKDIR /opt/weblication
CMD [ "php", "./wSetup.php" ]

# Expose ports.
EXPOSE 80
