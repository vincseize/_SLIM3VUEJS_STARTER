<?php

use Slim\Factory\AppFactory;
use Slim\Middleware\OutputBufferingMiddleware;


// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

// $app = AppFactory::create();
// $app->setBasePath('/_SLIM3VUEJS_STARTER');

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Register api
// require __DIR__ . '/../app/src/Classes/api.class.php';

// Register pagination
require __DIR__ . '/../app/src/Classes/pgn.class.php';

// -----------
$container = $app->getContainer();

// Run!
$app->run();
