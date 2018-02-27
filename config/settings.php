<?php

$dotEnv = new Dotenv\Dotenv(
    __DIR__ . '/../',
    '.env.config.ini'
);
$dotEnv->load();

return [

    // Slim3 settings
    'settings.displayErrorDetails' => isset($_ENV['displayErrorDetails']) ? (bool) $_ENV['displayErrorDetails'] : false,

    'logger' => [
        'filename' => __DIR__ . '/../var/log/app.log'
    ]

];
