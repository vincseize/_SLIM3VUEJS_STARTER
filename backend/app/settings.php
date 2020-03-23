<?php

$appSettingsFile = ROOT_DIR . '/../app_settings.json';
if (!file_exists($appSettingsFile)) {
    throw new \RuntimeException("Missing ROOT config file `app_settings.json`");
}

$appSettings = json_decode(file_get_contents($appSettingsFile), true);

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
            'host' => $appSettings['db']['host'],
            'user' => $appSettings['db']['user'],
            'passwd' => $appSettings['db']['pass'],
            'dbname' => $appSettings['db']['base'],
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
