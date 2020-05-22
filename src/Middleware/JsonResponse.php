<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JsonResponse implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        json_decode($response->getBody());
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response;
        }

        // Response is JSON
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
