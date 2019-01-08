<?php
// Add services here
// Variables available :
//   - $container
//   - $app

$container->register(
    new \App\Provider()
);

Ronanchilvers\Foundation\Facade\Facade::setContainer($container);
