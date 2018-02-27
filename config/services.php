<?php
// Add services here
// Variables available :
//   - $container
//   - $app

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [

    // Logger
    LoggerInterface::class => function (Container $c) {
        $settings = $c->get('logger');
        $logger = new Logger('default');
        $logger->pushHandler(
            new StreamHandler(
                $settings['filename']
            )
        );

        return $logger;
    },

];
