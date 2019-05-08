<?php

namespace App\Debug\Middleware;

use DebugBar\JavascriptRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Body;

/**
 * Middleware to add arbitrary headers to the application
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class DebugMiddleware
{
    /**
     * @var DebugBar\JavascriptRenderer
     */
    protected $renderer;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct(JavascriptRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Magic invocation method
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $debugHead = $this->renderer->renderHead();
        $debugBody = $this->renderer->render();

        $response = $next($request, $response);

        $content  = (string) $response->getBody();
        $content  = str_replace('</head>', $debugHead . '</head>', $content);
        $content  = str_replace('</body>', $debugBody . '</body>', $content);

        $body = new Body(fopen('php://temp', 'w+'));
        $body->write($content);

        return $response->withBody($body);
    }
}
