<?php

namespace App\Controller;

use App\Utility\ContainerAwareTrait;
use App\Utility\LoggerAwareTrait;
use App\Utility\TwigAwareTrait;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

/**
 * Controller for the index
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class IndexController
{
    use ContainerAwareTrait,
        LoggerAwareTrait,
        TwigAwareTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(
        Container $container,
        Twig $twig,
        LoggerInterface $logger
    ) {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setTwig($twig);
    }

    /**
     * Index action
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function index(ResponseInterface $response)
    {
        $this->logger()->info('Hit index');
        return $this->render(
            $response,
            'index/index.html.twig'
        );
    }
}
