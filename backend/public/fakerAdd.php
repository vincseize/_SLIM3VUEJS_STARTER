<?php

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

