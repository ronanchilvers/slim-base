<?php

use App\Middleware\ErrorMiddleware;
use Ronanchilvers\Container\Container;
use Ronanchilvers\Foundation\Facade\Facade;
use Slim\App;
use Slim\Factory\AppFactory;

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require("../vendor/autoload.php");

$container = new Container([
    'settings' => include('../config/settings.php')
]);

// Load app services
include("../config/services.php");

Facade::setContainer($container);

// Create the App object
AppFactory::setContainer($container);
$app = AppFactory::create();
$container->share(App::class, $app);

$app->addBodyParsingMiddleware();
include("../config/middleware.php");
$app->addRoutingMiddleware();
if ($container->get('settings')['displayErrorDetails']) {
    $app->addErrorMiddleware(true, true, true);
} else {
    $app->add(new ErrorMiddleware());
}

include("../config/routes.php");
$app->run();
