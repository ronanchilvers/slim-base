<?php

use App\Middleware\BootMiddleware;
use Ronanchilvers\Sessions\Middleware\Psr15;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
// Add middleware here
// Variables available :
//   - $container
//   - $app

// Twig support
$app->add(TwigMiddleware::class);

// Session handling
$app->add(new Psr15(
    $container->get('session')
));

// Application boot
$app->add(new BootMiddleware($container));
