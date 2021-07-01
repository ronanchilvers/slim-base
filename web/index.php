<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ronanchilvers\Container\Container;
use Ronanchilvers\Foundation\Facade\Facade;
use Slim\App;
use Slim\Factory\AppFactory;

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
$app->add(new ErrorMiddleware());

include("../config/routes.php");
$app->run();
