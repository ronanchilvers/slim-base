<?php

use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
// Add middleware here
// Variables available :
//   - $container
//   - $app

$app->add(TwigMiddleware::class);

// $app->add(new \Ronanchilvers\Sessions\SessionMiddleware(
//     $container->get('session')
// ));
