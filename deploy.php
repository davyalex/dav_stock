<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/TICAFRIQUE/Restaurant-NEUILLY-.git');

// Partage des fichiers et répertoires entre les déploiements
set('shared_files', ['.env']);
set('shared_dirs', ['storage']);
set('writable_dirs', ['storage', 'bootstrap/cache']);


// Hosts

host('production')
    ->set('hostname', 'ftp.maxisujets.net')  // Adresse IP ou domaine de ton serveur
    ->set('remote_user', 'restaurant@restaurant.maxisujets.net')
    ->set('deploy_path', '~/restaurant.maxisujets.net')
    ->set('branch', 'master'); // Branche Git à déployer (par défaut "main", remplace si nécessaire)



// Tâche pour exécuter `composer install`
task('deploy:composer_install', function () {
    run('cd {{release_path}} && composer install --no-dev --quiet --prefer-dist --optimize-autoloader');
});

// Tâche pour exécuter `php artisan key:generate`
task('artisan:key:generate', function () {
    run('cd {{release_path}} && php artisan key:generate');
});

// Tâche pour exécuter `php artisan migrate --seed`
task('artisan:migrate', function () {
    run('cd {{release_path}} && php artisan migrate --seed');
});

// Tâche pour exécuter `php artisan storage:link`
task('artisan:storage:link', function () {
    run('cd {{release_path}} && php artisan storage:link');
});

// Ordre d'exécution des tâches après le déploiement
after('deploy:symlink', 'deploy:composer_install');
after('deploy:symlink', 'artisan:migrate');
after('deploy:symlink', 'artisan:key:generate');
after('deploy:symlink', 'artisan:storage:link');


// Hooks

after('deploy:failed', 'deploy:unlock');
