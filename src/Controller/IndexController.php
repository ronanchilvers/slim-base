<?php

namespace App\Controller;

use App\Utility\ContainerAwareTrait;
use App\Utility\LoggerAwareTrait;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Controller for the index
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class IndexController
{
    use ContainerAwareTrait,
        LoggerAwareTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(
        Container $container,
        LoggerInterface $logger
    ) {
        $this->setContainer($container);
        $this->setLogger($logger);
    }

    /**
     * Index action
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function index(ResponseInterface $response)
    {
        $this->logger()->info('Hit index');
        return $response->write('Hallo');
    }
}
