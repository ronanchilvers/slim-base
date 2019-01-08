<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ronanchilvers\Foundation\Slim\Traits\TwigAwareTrait;
use Slim\Views\Twig;

/**
 * Controller for the index
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class IndexController
{
    use TwigAwareTrait;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(
        Twig $twig
    ) {
        $this->setTwig($twig);
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
        return $this->render(
            $response,
            'index/index.html.twig'
        );
    }
}
