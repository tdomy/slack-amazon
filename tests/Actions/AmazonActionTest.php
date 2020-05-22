<?php

namespace TestApp\Actions;

use App\Actions\AmazonAction;
use Mockery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface as Stream;
use TestApp\TestCase;

class AmazonActionTest extends TestCase
{
    /**
     * @dataProvider requestBodyProvider
     */
    public function testAction($body)
    {
        $request = $this->createRequest($body);
        $response = $this->createResponse();
        $action = new AmazonAction();
        $action->__invoke($request, $response);
    }

    private function createRequest($parsed_body)
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getParsedBody')
            ->andReturn($parsed_body);

        return $request;
    }

    private function createResponse()
    {
        $stream = Mockery::mock(Stream::class);
        $stream->shouldReceive('write')->once();

        $response = Mockery::mock(Response::class);
        $response->shouldReceive('getBody')
            ->andReturn($stream);

        return $response;
    }

    public function requestBodyProvider()
    {
        return [
            [
                ['text' => 'hogehoge'],
            ],
            [
                ['text' => ''],
            ],
            [
                [],
            ],
            [
                null,
            ],
        ];
    }
}
