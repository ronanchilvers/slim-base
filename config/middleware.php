<?php

use Ronanchilvers\Sessions\Middleware\Psr15;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
// Add middleware here
// Variables available :
//   - $container
//   - $app

$app->add(TwigMiddleware::class);

$app->add(new Psr15(
    $container->get('session')
));
