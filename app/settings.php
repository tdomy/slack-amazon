<?php
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'display_error_details' => getenv('DISPLAY_ERROR_DETAILS'),
            'slack' => [
                'signing_secret' => getenv('SLACK_SIGNING_SECRET'),
            ],
        ],
    ]);
};