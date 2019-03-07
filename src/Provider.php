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
use Ronanchilvers\Sessions\NativeStorage;
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
        $container->set(LoggerInterface::class, function (ContainerInterface $c) {
            $settings = $c->get('settings')['logger'];
            $logger = new Logger('default');
            $logger->pushHandler(
                new StreamHandler(
                    $settings['filename']
                )
            );
            Registry::addLogger($logger);

            return $logger;
        });

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

        $container->set('session.storage.options', function ($c) {
            return $c->get('settings')['session'];
        });

        $container->share('session.storage', function ($c) {
            $options = $c->get('session.storage.options');

            return new \Ronanchilvers\Sessions\Storage\CookieStorage(
                $options
            );
        });

        $container->share('session', function ($c) {
            return new \Ronanchilvers\Sessions\Session(
                $c->get('session.storage')
            );
        });

        $container->share('eloquent.capsule', function ($c) {
            $options = $c->get('settings')['database'];
            $capsule = new Manager();
            $capsule->addConnection($options);
            $capsule->setAsGlobal();
            // $capsule->bootEloquent();

            return $capsule;
        });
    }
}
