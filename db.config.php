<?php

if (file_exists(__DIR__ . '/.env')) {
    $dotEnv = new Dotenv\Dotenv(
        __DIR__ . '/',
        '.env'
    );
    $dotEnv->load();
}

return [

    // PDO Instance
    'pdo' => new PDO(
        isset($_ENV['database.dsn']) ? (string) $_ENV['database.dsn'] : null,
        isset($_ENV['database.username']) ? (string) $_ENV['database.username'] : null,
        isset($_ENV['database.password']) ? (string) $_ENV['database.password'] : null
    ),

    // Output directory for generated models
    'output_dir' => 'generated',

    // The namespace for generated models
    'namespace' => 'App\\Generated',

];
