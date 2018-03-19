<?php

namespace App\Controller;

use App\Utility\ContainerAwareTrait;
use App\Utility\LoggerAwareTrait;
use App\Utility\TwigAwareTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
        ContainerInterface $container,
        Twig $twig,
        LoggerInterface $logger
    ) {
        $this->setContainer($container);
        $this->setTwig($twig);
        $this->setLogger($logger);
    }

    /**
     * Index action
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function index(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        // $this->logger()->info('Hit index');
        return $this->render(
            $response,
            'index/index.html.twig'
        );
    }
}
