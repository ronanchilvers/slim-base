<?php
// Add services here
// Variables available :
//   - $container
//   - $app

use App\Controller\IndexController;
use Aura\Sql\ExtendedPdo;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

// Logger
$container->set(LoggerInterface::class, function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger('default');
    $logger->pushHandler(
        new StreamHandler(
            $settings['filename']
        )
    );
    Monolog\Registry::addLogger($logger);

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

// Controllers
// foreach ([IndexController::class] as $class) {
//     $container->set($class, function ($c) use ($class) {
//         return new $class(
//             $c,
//             $c->get(Twig::class),
//             $c->get(LoggerInterface::class)
//         );
//     });
// }

// Database
// ExtendedPdo::class => function (ContainerInterface $c) {
//     $settings = $c->get('config')['database'];
//     $pdo = new ExtendedPdo(
//         $settings['dsn'],
//         $settings['username'],
//         $settings['password']
//     );

//     return $pdo;
// },
