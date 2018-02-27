<?php
// Add services here
// Variables available :
//   - $container
//   - $app

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

return [

    // Logger
    LoggerInterface::class => function (Container $c) {
        $settings = $c->get('settings_logger');
        $logger = new Logger('default');
        $logger->pushHandler(
            new StreamHandler(
                $settings['filename']
            )
        );

        return $logger;
    },

    // Twig
    Twig::class => function (Container $c) {
        $settings = $c->get('settings_twig');
        $view = new Twig(
            $settings['templates'],
            [
                'cache' => $settings['cache']
            ]
        );
        $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
        $view->addExtension(new TwigExtension($c['router'], $basePath));

        return $view;
    },

];
