<?php

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => APP_DIR . '/templates',
            'twig' => [
                'cache' => ROOT_DIR . '/cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => ROOT_DIR . '/log/app.log',
            'level' => \Monolog\Logger::ERROR,
        ],

        // db settings
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'user' => 'polo',
            'dbname' => 'slim3vue-starter',
            'passwd' => 'poiazemlkqsd',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'flags' => [
                PDO::ATTR_PERSISTENT => false,
                // Enable exceptions
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Set default fetch mode
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ],

        // db results
        'n_results' => [
            'n_results_default' => '10',
            'n_results_array' => ['5','10','25','50','100'],
        ],
    ],
];
