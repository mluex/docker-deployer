# mluex/deployer:6.8 is now the contract-tested ghcr.io/bannerstop/deployer:6.8 (github.com/bannerstop/docker,
# deployer/6.8): Deployer 6 on the patched PHP 7.4 of bannerstop/php (EOL security backports), Node.js 22,
# npm, yarn 1, Composer 2, ssh, rsync, git. Same contract as before (entrypoint copies /transfer/.ssh,
# /opt/deployer/vendor/bin/dep, helper functions, "composer require <recipes> ^6.0 && php-fpm").
#
# The old image ran PHP 7.4.25 from 2021 with no security fixes. Kept as a thin alias so the repos'
# .deployer/docker-compose.yml files do not have to change; new setups can use bannerstop/deployer directly.
FROM ghcr.io/bannerstop/deployer:6.8
