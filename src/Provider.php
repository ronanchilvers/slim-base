<?php

namespace App;

use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Registry;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Ronanchilvers\Container\Container;
use Ronanchilvers\Container\ServiceProviderInterface;
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
        $container->set('monolog', function (ContainerInterface $c) {
            $settings = $c->get('settings');
            $loggerSettings = $settings['logger'];
            $logger = new Logger('default');
            if (isset($loggerSettings['filename'])) {
                $logger->pushHandler(
                    new StreamHandler(
                        $loggerSettings['filename'],
                        Logger::DEBUG
                    )
                );
            }
            Registry::addLogger($logger);

            return $logger;
        });
        $container->set(LoggerInterface::class, '@monolog');

        // Twig
        $container->set(Twig::class, function (ContainerInterface $c) {
            $settings = $c->get('settings')['twig'];
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
        });

        // Session
        $container->set('session.storage.options', function ($c) {
            return $c->get('settings')['session'];
        });
        $container->share('session.storage', function ($c) {
            $options = $c->get('session.storage.options');

            return new CookieStorage(
                $options
            );
        });
        $container->share('session', function ($c) {
            return new Session(
                $c->get('session.storage')
            );
        });

        // Eloquent
        $container->share('eloquent.capsule', function ($c) {
            $options = $c->get('settings')['database'];
            $capsule = new Manager();
            $capsule->addConnection($options);
            $capsule->setAsGlobal();

            return $capsule;
        });
    }
}
