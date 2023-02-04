#!/bin/sh

# Import SSH config
printf "\n\nStarting import of SSH config...\n\n"

mkdir -p /tmp/.ssh/
cp -R /tmp/.ssh/ /root/
chown -R root:root /root/.ssh

printf "\n\nDone.\n\n"

# See docker-php-entrypoint
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"