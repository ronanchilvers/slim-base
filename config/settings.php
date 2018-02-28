<?php

$dotEnv = new Dotenv\Dotenv(
    __DIR__ . '/../',
    '.env.config.ini'
);
$dotEnv->load();

return [

    // Slim3 settings
    'settings.displayErrorDetails' => isset($_ENV['displayErrorDetails']) ? (bool) $_ENV['displayErrorDetails'] : false,

    'config' => [

        // Logging
        'logger' => [
            'filename' => __DIR__ . '/../var/log/app.log'
        ],

        // Twig
        'twig' => [
            'templates' => __DIR__ . '/../templates',
            'cache' => isset($_ENV['twig.cache']) ? $_ENV['twig.cache'] : false,
        ],

        'database' => [
            'dsn' => 'mysql:host=localhost;dbname=certificate_checker_dev',
            'username' => 'dev',
            'password' => 'dev',
        ],

    ],

];
