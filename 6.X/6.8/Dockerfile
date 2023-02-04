FROM php:7.4.25-fpm-buster

# Install requirements
RUN requirements="libcurl3-dev curl debconf git apt-transport-https apt-utils build-essential locales acl wget libzip-dev zip unzip sudo vim nano gnupg rsync" \
    && apt-get update \
    && apt-get install -y $requirements \
    && rm -rf /var/lib/apt/lists/*

# Install php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions
RUN chmod uga+x /usr/bin/install-php-extensions \
    && sync

# Install nodejs w/ npm & yarn in order to run builds
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get update && \
    apt-get remove -y nodejs-doc && \
    apt-get install -y --no-install-recommends nodejs && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && \
    apt-get install -y --no-install-recommends yarn && \
    npm install -g npm

# Configure & prepare PHP
RUN install-php-extensions zip

RUN echo "memory_limit=-1" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# Prepare deployer directory
RUN mkdir -p /opt/deployer/
ADD https://raw.githubusercontent.com/mluex/docker-dev-deployer/master/6.X/shared/composer.json \
    /opt/deployer/composer.json

RUN mkdir -p /opt/deployer/functions/
ADD https://raw.githubusercontent.com/mluex/docker-dev-deployer/master/6.X/shared/functions/parse_home_dir.php \
    /opt/deployer/functions/parse_home_dir.php
ADD https://raw.githubusercontent.com/mluex/docker-dev-deployer/master/6.X/shared/functions/resolve_cli_arguments.php \
    /opt/deployer/functions/resolve_cli_arguments.php
ADD https://raw.githubusercontent.com/mluex/docker-dev-deployer/master/6.X/shared/functions/rsync_upload.php \
    /opt/deployer/functions/rsync_upload.php

WORKDIR /opt/deployer/

# Install deployer
RUN cd /opt/deployer/ && \
    composer install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest

# Inject bootstrap script
ADD https://raw.githubusercontent.com/mluex/docker-dev-deployer/master/6.X/shared/bootstrap.sh \
    /usr/local/bin/bootstrap.sh
RUN chmod +x /usr/local/bin/bootstrap.sh

ENTRYPOINT ["bootstrap.sh"]

CMD ["php-fpm"]