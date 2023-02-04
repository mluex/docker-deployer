#!/bin/sh

# Import SSH config
mkdir -p /transfer/.ssh/
cp -R /transfer/.ssh/ /root/
chown -R root:root /root/.ssh

# See docker-php-entrypoint
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"