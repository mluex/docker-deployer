#!/bin/sh

# Import SSH config
mkdir -p /tmp/.ssh/
cp -R /tmp/.ssh/ /root/
chown -R root:root /root/.ssh

# Start php-fpm
php-fpm --daemonize

exec "$@"