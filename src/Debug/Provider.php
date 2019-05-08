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
use Ronanchilvers\Container\ServiceProviderInterface;
use Ronanchilvers\Container\Container;

/**
 * Provider for PHPDebugBar
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class Provider implements ServiceProviderInterface
{
    /**
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Container $container)
    {
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

        $container->set('debug.middleware', function (Container $container) {
            return new DebugMiddleware(
                $container->get('debug.bar.renderer')
            );
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

        // Monolog
        $container->extend('monolog', function ($logger, $container){
            $container->get('debug.bar')->addCollector(
                new MonologCollector($logger)
            );

            return $logger;
        });
    }
}
