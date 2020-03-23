<?php

define('ROOT_DIR', dirname(__DIR__));
define('SRC_DIR', ROOT_DIR . '/src');

require ROOT_DIR . '/vendor/autoload.php';

$app = new \Slim\App;

// Activating routes in frontend/ subfolder
$container = $app->getContainer();
$container['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

// Main route: ENTRYPOINT (to serve front build)
$app->get('/', function ($request, $response) {
    $frontIndexFile = ROOT_DIR . '/public/bundle/index.html';

    if (!file_exists($frontIndexFile)) {
        $errorFile = ROOT_DIR . '/public/static/error.html';
        $errorContent = file_get_contents($errorFile);
        $response->getBody()->write($errorContent);
        return $response;
    }

    $frontIndexContent = file_get_contents($frontIndexFile);
    $response->getBody()->write($frontIndexContent);
    return $response;
});

// Customer Routes
require SRC_DIR . '/Api/routes/clients.php';

$app->run();
