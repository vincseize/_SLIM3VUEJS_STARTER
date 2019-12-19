<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Faker class for fake data
$container['faker'] = function ($c) {
    return Faker\Factory::create();
};

// -----------------------------------------------------------------------------
// Service database
// -----------------------------------------------------------------------------
	
// PDO database 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['passwd']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// PDO database actions 
$container['listTables'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['passwd']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 
    $sql = "SHOW TABLES";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $tables = $statement->fetchAll(PDO::FETCH_NUM);
    return $tables;
};

// PDO database actions 
$container['n_results'] = function ($c) {
    return $c->get('settings')['n_results'];
};

// Api class
$container['Api'] = function ($c) {
    return Api::class;
};

// Pagination class
$container['Pagination'] = function ($c) {
    return Pagination::class;
};

// -----------------------------------------------------------------------------
// Action factories twig
// -----------------------------------------------------------------------------

$container[App\Action\HomeAction::class] = function ($c) {
    return new App\Action\HomeAction($c->get('view'), $c->get('logger'));
};

$container[App\Action\TimeAction::class] = function ($c) {
    return new App\Action\TimeAction($c->get('view'), $c->get('logger'));
};

$container[App\Action\HelloAction::class] = function ($c) {
    return new App\Action\HelloAction($c->get('view'), $c->get('logger'));
};

$container[App\Action\TestApiAction::class] = function ($c) {
    return new App\Action\TestApiAction($c->get('view'), $c->get('logger'), 
    $c->get('db'), 
    $c->get('Api'),
    $c->get('Pagination'), 
    $c->get('faker'), 
    $c->get('settings'), 
    $c->get('listTables'),
    $c->get('n_results')
    );
};


