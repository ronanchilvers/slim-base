<?php

namespace App\Middleware;

use App\Facades\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 * Middleware to handle errors
 *
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class ErrorMiddleware implements MiddlewareInterface
{
    /**
     * @see Psr\Http\Server\MiddlewareInterface::process()
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Exception $ex) {
            $response = (new Response())
                ->withStatus($ex->getCode());

            return View::render(
                $response,
                'error.html.twig',
                [
                    'exception' => $ex,
                ]
            );
        }
    }
}
