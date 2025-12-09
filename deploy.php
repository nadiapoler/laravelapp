<?php
namespace Deployer;

require 'recipe/laravel.php';

set('application', 'LaravelApp');

set('repository', 'git@github.com:nadiapoler/laravelapp.git');

add('shared_files', ['.env']);
add('shared_dirs', ['storage']);
add('writable_dirs', ['storage', 'bootstrap/cache']);

host('deployer.cipfpbatoi.es')
    ->set('remote_user', 'sa04-deployer')
    ->set('deploy_path', '/var/www/es-cipfpbatoi-deployer/html');

set('git_tty', true); 

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.3-fpm restart');
});

after('deploy', 'reload:php-fpm');
after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'artisan:migrate');
