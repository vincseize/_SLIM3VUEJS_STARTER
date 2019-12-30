<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

// -----------
// https://github.com/fzaninotto/Faker

$faker = Faker\Factory::create();
$entries = array();
// it's just your fields name, add infinite ...
$entries["nom"] = $faker->name;
$entries["email"] = $faker->email;
$entries["id_hotel"] = $faker->randomDigitNotNull(5);
$entries["numero"] = $faker->randomDigitNotNull(10);

$data = json_encode($entries);
echo $data;

