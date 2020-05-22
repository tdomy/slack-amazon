<?php

namespace TestApp\Middleware;

use App\Middleware\JsonResponse;
use Mockery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface as Stream;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use TestApp\TestCase;

class JsonResponseTest extends TestCase
{
    public function testJsonResponse()
    {
        $response = $this->createResponse('{"key":"value"}');
        $afterResponse = Mockery::mock(Response::class);
        $response->shouldReceive('withHeader')
            ->with('Content-Type', 'application/json; charset=utf-8')
            ->once()
            ->andReturn($afterResponse);
        $request_handler = $this->createRequestHandler($response);

        $middleware = new JsonResponse();
        $this->assertSame($afterResponse, $middleware->process(Mockery::mock(Request::class), $request_handler));
    }

    public function testNotJsonResponse()
    {
        $response = $this->createResponse('<html></html>');
        $response->shouldNotReceive('withHeader');
        $request_handler = $this->createRequestHandler($response);

        $middleware = new JsonResponse();
        $this->assertSame($response, $middleware->process(Mockery::mock(Request::class), $request_handler));
    }

    private function createResponse(string $response_body)
    {
        $stream = Mockery::mock(Stream::class);
        $stream->shouldReceive('__toString')
            ->andReturn($response_body);

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody')
            ->andReturn($stream);

        return $response;
    }

    private function createRequestHandler($response)
    {
        $mock = Mockery::mock(RequestHandler::class);

        $mock->shouldReceive('handle')
            ->andReturn($response);

        return $mock;
    }
}
