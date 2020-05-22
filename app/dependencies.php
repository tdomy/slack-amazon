<?php
use App\Service\PostService;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use SlackMiddleware\Verification;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Verification::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');
            return new Verification($settings['slack']['signing_secret']);
        },
    ]);
};