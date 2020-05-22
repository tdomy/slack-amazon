<?php
use App\Middleware\JsonResponse;
use Slim\App;

return function (App $app) {
    $app->add(JsonResponse::class);
};