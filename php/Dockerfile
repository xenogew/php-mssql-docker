FROM php:8.4-fpm-bookworm
WORKDIR /application

ENV ACCEPT_EULA=Y

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive
ARG DEBIAN_VERSION

# LEGACY packages that ever installed when last time research of PHP 7.4,
#        not sure it related to the other factor when run any function,
#        please check it and confirm by your own envrionment.
#   NOTICE: libraries list from `user:webchi` 
#     gnupg libpq-dev libzip-dev
#   NOTICE: libraries list from `me`
#     apt-utils libxml2-dev gnupg apt-transport-https

# Install selected extensions and other stuff
RUN apt update \
    && apt -y --no-install-recommends install gnupg libicu-dev \
    && apt clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install MS ODBC Driver for SQL Server
RUN DEBIAN_VERSION=$(cat /etc/debian_version | cut -d. -f1) \
    && curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg \
    && curl https://packages.microsoft.com/config/debian/${DEBIAN_VERSION}/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt update \
    && apt -y --no-install-recommends install msodbcsql18 unixodbc-dev \
    && pecl install sqlsrv \
    && pecl install pdo_sqlsrv \
    && echo "extension=pdo_sqlsrv.so" >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/30-pdo_sqlsrv.ini \
    && echo "extension=sqlsrv.so" >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/30-sqlsrv.ini \
    && apt clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install required extensions
RUN docker-php-ext-install intl mysqli pdo pdo_mysql
