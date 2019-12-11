<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
// require 'DbOperations.php';
$app = new \Slim\App($settings);


// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Register api
require __DIR__ . '/../app/api.class.php';


// -----------
$container = $app->getContainer();

// // $faker = Faker\Factory::create();
// // echo $faker->name;
// // echo "<br>";

// // $obj = new Api;
// // $result = $obj->test();
// $result = Api::test();
// echo $result;
// echo "<br>";
// // $friend = Api->find_one($id);
// // $result = $obj->test();
// $table='clients';
// $column1='nom';
// $column2='email';
// $result = Api::populate('clients',$column1,$column2);
// echo $result;


// return;

// Run!
$app->run();
