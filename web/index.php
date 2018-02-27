<?php

use App\App;

require("../vendor/autoload.php");

// Initialise App
$app = new App;
include("../config/routes.php");
$app->run();
