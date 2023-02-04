<?php

namespace Deployer;

require_once __DIR__ . '/vendor/deployer/deployer/recipe/symfony4.php';
require_once __DIR__ . '/functions/rsync_upload.php';

// Deployment config
set('application', 'mycompany/myapp');
set('repository', 'git@github.com:mycompany/myapp.git');
set('keep_releases', 4);
set('default_timeout', 900);
set('build_path', '/opt/build/app/');

inventory('hosts.yml');

// Remove .env.local.php from shared_files and add .Halite.key
set('shared_files', ['.env.local', '.Halite.key']);

set('bin/yarn', function () {
    return locateBinaryPath('yarn');
});

// Inject migration into pipeline
before('deploy:cache:clear', 'database:migrate');

// Setup build pipeline
task('build:yarn:install', function() {
    run('cd {{build_path}} && {{bin/yarn}} install');
})->local();
task('build:yarn:build', function() {
    run('cd {{build_path}} && {{bin/yarn}} build');
})->local();
task('build', [
    'build:yarn:install',
    'build:yarn:build',
]);
before('deploy:prepare', 'build');

// Upload build artifacts
task('upload', function () {
    rsyncUpload('{{build_path}}/public/build', '{{release_path}}/public');
});
before('deploy:cache:clear', 'upload');
