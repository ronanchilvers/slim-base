<?php

use App\App;

require("../vendor/autoload.php");

// Initialise App
$app = new App;
$container = $app->getContainer();

// Load services
include("../config/services.php");

// Load routes
include("../config/routes.php");

$app->run();
