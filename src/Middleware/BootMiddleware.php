<?php

namespace App\Middleware;

use App\Traits\BootTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware to boot the application
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class BootMiddleware implements MiddlewareInterface
{
    use BootTrait;

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
        $this->boot($this->container);

        return $handler->handle($request);
    }
}
