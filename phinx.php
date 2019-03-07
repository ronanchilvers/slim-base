<?php
$settings = include(__DIR__ . '/config/settings.php');
$config   = $settings['database'];

return [

    // General settings
    'version_order' => 'creation',

    // File paths
    'paths' => [
        'migrations' => [
            __DIR__ . '/config/database/migrations',
        ],
        'seeds' => [
            __DIR__ . '/config/database/seeds',
        ],
    ],

    'environments' => [

        // Phinx defaults
        'default_migration_table' => 'phinxlog',
        'default_database'        => 'default',

        // Database definition
        'default' => [
            'adapter'   => $config['driver'],
            'host'      => $config['host'],
            'port'      => $config['port'],
            'name'      => $config['database'],
            'user'      => $config['username'],
            'pass'      => $config['password'],
            'charset'   => $config['charset'],
            'collation' => $config['collation'],
        ],

    ],

];
