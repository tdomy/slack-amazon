<?php
declare(strict_types=1);

use App\Actions\AmazonAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use SlackMiddleware\Verification;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('OK');
        return $response;
    });

    $app->post('/amazon', AmazonAction::class)->add(Verification::class);
};
