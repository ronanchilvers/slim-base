<?php

namespace App\Middleware;

use App\Facades\Log;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ronanchilvers\Foundation\Facade\Facade;
use Ronanchilvers\Orm\Orm;

/**
 * Middleware to boot the application
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class BootMiddleware implements MiddlewareInterface
{
    /**
     * @var Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @see Psr\Http\Server\MiddlewareInterface::process()
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Configure facades
        Facade::setContainer($this->container);

        // Configure ORM
        Orm::setConnection($this->container->get(PDO::class));
        Orm::getEmitter()->on('query.init', function($sql, $params) {
            Log::debug('Query init', [
                'sql'    => $sql,
                'params' => $params,
            ]);
        });

        return $handler->handle($request);
    }
}
