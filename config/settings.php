<?php

$settings = [
    // Slim3 settings
    'displayErrorDetails' => false,

    // Logging
    'logger' => [
        'filename' => __DIR__ . '/../var/log/app.log'
    ],

    // Twig
    'twig' => [
        'templates' => __DIR__ . '/../templates',
        'cache' => __DIR__ . '/../var/twig',
    ],

    // Session settings
    'session' => [
        'encryption.key' => null,
    ],

    'database' => [
        'driver'   => 'sqlite',
        'host'     => '',
        'database' => __DIR__ . '/../var/database/app.sq3',
        'username' => '',
        'password' => '',
        'charset'  => 'utf8',
        'collation'=> 'utf8_unicode_ci',
        'prefix'   => '',
    ],
];

$localConfig = __DIR__ . '/../local.config.php';
if (file_exists($localConfig)) {
    $localSettings = include($localConfig);
    $settings = array_replace_recursive($settings, $localSettings);
}

return $settings;
