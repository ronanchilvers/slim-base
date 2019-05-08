<?php

namespace App\Debug;

use App\Debug\Middleware\DebugMiddleware;
use App\Twig\DebugExtension;
use DebugBar\Bridge\MonologCollector;
use DebugBar\Bridge\Twig\TraceableTwigEnvironment;
use DebugBar\Bridge\Twig\TwigCollector;
use DebugBar\DataCollector\ConfigCollector;
use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\StandardDebugBar;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

/**
 * Provider for PHPDebugBar
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Provider implements
    ServiceProviderInterface,
    BootableProviderInterface
{
    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Container $pimple)
    {
        $pimple['debug.bar.renderer'] = function (Container $container) {
            $bar      = $container['debug.bar'];
            $renderer = $bar->getJavascriptRenderer()
                 ->setBaseUrl('/debugbar')
                 ->setEnableJqueryNoConflict(true);

            return $renderer;
        };

        $pimple['debug.bar'] = function (Container $container) {
            $bar = new StandardDebugBar();
            $bar->addCollector(
                new ConfigCollector($container['config'])
            );

            return $bar;
        };

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

        // Monolog
        $pimple->extend('monolog', function ($logger, $container){
            $container['debug.bar']->addCollector(
                new MonologCollector($logger)
            );

            return $logger;
        });
    }
}
