<?php





return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
            'level' => \Monolog\Logger::ERROR,
        ],

        // db settings
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'user' => 'root',
            'dbname' => 'booking_vuejs',
            'passwd' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
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


// // Path settings
// // $settings['root'] = dirname(__DIR__);
// // $settings['temp'] = $settings['root'] . '/tmp';
// // $settings['public'] = $settings['root'] . '/public';