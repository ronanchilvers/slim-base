<?php

use App\Controller\IndexController;
use Ronanchilvers\Container\Container;
use Slim\App;
use Slim\DefaultServicesProvider;

require("../vendor/autoload.php");

// Slim3 support
$settings = array_merge([
    'httpVersion' => '1.1',
    'responseChunkSize' => 4096,
    'outputBuffering' => 'append',
    'determineRouteBeforeAppMiddleware' => false,
    'displayErrorDetails' => false,
    'addContentLengthHeader' => true,
    'routerCacheFile' => false,
], include('../config/settings.php'));

$container = new Container(['settings' => $settings]);
(new DefaultServicesProvider())->register($container);

// Load app services
include("../config/services.php");

// Create the App object
$app = new App($container);
include("../config/routes.php");
$app->run();
