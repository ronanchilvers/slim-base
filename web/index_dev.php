<?php

use App\Controller\IndexController;
use App\Slim\App;
use DebugBar\DataCollector\ConfigCollector;
use DebugBar\StandardDebugBar;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ronanchilvers\Container\Slim\Container;
use Slim\Http\Body;

if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require("../vendor/autoload.php");

$container = new Container([
    'settings' => include('../config/settings.php')
]);

// Load app services
include("../config/services.php");

// Add debugging services
$container->set('debug.bar.renderer', function (Container $container) {
    $bar      = $container->get('debug.bar');
    $renderer = $bar->getJavascriptRenderer()
         ->setBaseUrl('/debugbar')
         ->setEnableJqueryNoConflict(true);

    return $renderer;
});
$container->set('debug.bar', function (Container $container) {
    $bar = new StandardDebugBar();
    $bar->addCollector(
        new ConfigCollector($container->get('settings'))
    );

    return $bar;
});
$container->extend('monolog', function ($logger, $container){
    $container['debug.bar']->addCollector(
        new MonologCollector($logger)
    );

    return $logger;
});
// Twig override
// $pimple->extend('twig', function ($twig, $container) {
//     $bar = $container['debug.bar'];
//     $traceableTwig = new TraceableTwigEnvironment($twig, $bar['time']);
//     $bar->addCollector(new TwigCollector($traceableTwig));

//     return $traceableTwig;
// });

// PDO Override
// $pimple->extend('PDO', function ($pdo, $container){
//     $traceablePDO = new TraceablePDO($pdo);
//     $container['debug.bar']->addCollector(
//         new PDOCollector($traceablePDO)
//     );

//     return $traceablePDO;
// });

// Create the App object
$app = new App($container);
include("../config/middleware.php");
$app->add(function (ServerRequestInterface $request, ResponseInterface $response, $next) use ($container) {
    $renderer = $container->get('debug.bar.renderer');
    $debugHead = $renderer->renderHead();
    $debugBody = $renderer->render();

    $response = $next($request, $response);

    $content  = (string) $response->getBody();
    $content  = str_replace('</head>', $debugHead . '</head>', $content);
    $content  = str_replace('</body>', $debugBody . '</body>', $content);

    $body = new Body(fopen('php://temp', 'w+'));
    $body->write($content);

    return $response->withBody($body);
});

include("../config/routes.php");
$app->run();
