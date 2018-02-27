<?php
// Settings for app

$dotEnv = new Dotenv\Dotenv(
    __DIR__ . '/../',
    '.env.config.ini'
);
$dotEnv->load();

return [
    'settings.displayErrorDetails' => isset($_ENV['displayErrorDetails']) ? (bool) $_ENV['displayErrorDetails'] : false,
];
