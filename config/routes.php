<?php
// Add routes here
// Variables available :
//   - $container
//   - $app

use App\Controller\IndexController;

$app->get(
    '/',
    IndexController::class . ':index'
)->setName('index');
