<?php
session_start();

define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');

require ROOT_DIR . '/vendor/autoload.php';

// Instantiate the app
$settings = require APP_DIR . '/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require APP_DIR . '/dependencies.php';

// Register routes
require APP_DIR . '/routes.php';

// Run!
$app->run();
