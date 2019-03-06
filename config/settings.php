<?php

if (file_exists(__DIR__ . '/../.env')) {
    $dotEnv = new Dotenv\Dotenv(
        __DIR__ . '/../',
        '.env'
    );
    $dotEnv->load();
}

return [
    // Slim3 settings
    'displayErrorDetails' => isset($_ENV['displayErrorDetails']) ? (bool) $_ENV['displayErrorDetails'] : false,

    // Logging
    'logger' => [
        'filename' => __DIR__ . '/../var/log/app.log'
    ],

    // Twig
    'twig' => [
        'templates' => __DIR__ . '/../templates',
        'cache' => isset($_ENV['twig.cache']) ? $_ENV['twig.cache'] : false,
    ],

    // Session settings
    'session' => [
        'encryption.key' => isset($_ENV['encryption.key']) ? (string) $_ENV['encryption.key'] : null,
    ],

    'database' => [
        'dsn'      => isset($_ENV['database.dsn']) ? (string) $_ENV['database.dsn'] : 'sqlite::memory:',
        'username' => isset($_ENV['database.username']) ? (string) $_ENV['database.username'] : null,
        'password' => isset($_ENV['database.password']) ? (string) $_ENV['database.password'] : null,
    ],
];
