<?php

namespace App\Controller;

use App\Utility\ContainerAwareTrait;
use DI\Container;
use Psr\Http\Message\ResponseInterface;

/**
 * Controller for the index
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class IndexController
{
    use ContainerAwareTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(
        Container $container
    ) {
        $this->setContainer($container);
    }

    /**
     * Index action
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function index(ResponseInterface $response)
    {
        return $response->write('Hallo');
    }
}
