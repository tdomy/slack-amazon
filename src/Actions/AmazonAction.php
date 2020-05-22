<?php

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AmazonAction
{
    /**
     * @param  Request  $request
     * @param  Response $response
     * @return Response
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $params = $request->getParsedBody();

        if (!isset($params['text']) || $params['text'] === '' || $params['text'] === null) {
            $response->getBody()->write(json_encode([
                'response_type' => 'in_channel',
                'text'          => 'Input word to search.',
            ]));
            return $response;
        }

        $response->getBody()->write(json_encode([
            'response_type' => 'in_channel',
            'text'          => '<https://www.amazon.co.jp/s?' . http_build_query(['k' => $params['text']]) . '>',
        ]));

        return $response;
    }
}
