<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Registry;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Ronanchilvers\Sessions\Session;
use Ronanchilvers\Sessions\Storage\CookieStorage;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * App service provider
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Provider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Container $container)
    {
        // Logger
        $container[LoggerInterface::class] = function (ContainerInterface $c) {
            $settings = $c['settings'];
            $loggerSettings = $settings['logger'];
            $logger = new Logger('default');
            if (isset($loggerSettings['filename']) && false !== $loggerSettings['filename']) {
                $logger->pushHandler(
                    new StreamHandler(
                        $loggerSettings['filename'],
                        Logger::DEBUG
                    )
                );
            }
            Registry::addLogger($logger);

            return $logger;
        };

        // Twig
        $container[Twig::class] = function (ContainerInterface $c) {
            $settings = $c['settings']['twig'];
            $view = new Twig(
                $settings['templates'],
                [
                    'cache' => $settings['cache']
                ]
            );
            $request = $c->get('request');
            $basePath = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');
            $view->addExtension(
                new TwigExtension(
                    $c->get('router'),
                    $basePath
                )
            );

            return $view;
        };

        // Session
        $container['session.storage.options'] = function ($c) {
            return $c['settings']['session'];
        };
        $container['session.storage'] = function ($c) {
            $options = $c['session.storage.options'];

            return new CookieStorage(
                $options
            );
        };
        $container['session'] = function ($c) {
            return new Session(
                $c['session.storage']
            );
        };

        // Database
        $container[PDO::class] = function ($c) {
            $settings = $c['settings']['database'];
            return new PDO(
                $settings['dsn'],
                $settings['username'],
                $settings['password'],
                $settings['options']
            );
        };
    }
}
