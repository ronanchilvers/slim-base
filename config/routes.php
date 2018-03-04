<?php
// Add routes here
// Variables available :
//   - $container
//   - $app

use App\Controller\IndexController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/', IndexController::class . ':index');
