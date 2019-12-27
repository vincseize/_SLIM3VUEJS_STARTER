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
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

// Register api
require __DIR__ . '/../app/src/Classes/api.class.php';

// -----------------------------------------------------------------------------
// Service database
// -----------------------------------------------------------------------------

// PDO database library 
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
        $settings['user'], $settings['passwd']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$db = $container['db'];

// -----------------------------------------------------------------------------
// For response
// -----------------------------------------------------------------------------

$result_array = array();
$response = "FALSE";

// -----------------------------------------------------------------------------

if(isset($_POST["table"])){

        $table = $_POST["table"];
        $Api = new Api($db,$table);
        $faker = Faker\Factory::create();

        // -----------------------------------------------------------------------------
        // Add fake
        // -----------------------------------------------------------------------------

        if(isset($_POST["crud"]) && $_POST["crud"]=="add" && isset($_POST["fake"])=="true" && $_POST["fake"]=="true")
        {
            $data = array( 
                'nom' => htmlspecialchars($faker->name), 
                'email' => htmlspecialchars($faker->email) 
            );
            $doublons = array( 'col' => 'email', 'value' => true ); // true -> is accept doublons on col choosed

            // as class
            // $res_populate = Api::addFake($data,$doublons);

            // as instance / object
            $res_populate = $Api->addFake($data,$doublons);

        }

        // -----------------------------------------------------------------------------
        // Add
        // -----------------------------------------------------------------------------


        if(isset($_POST["crud"]) && $_POST["crud"]=="add" && isset($_POST["fake"])=="true" && $_POST["fake"]=="false")
        {
            $data = array( 
                'nom' => htmlspecialchars($_POST["nom"]), 
                'email' => htmlspecialchars($_POST["email"]) 
            );
            $doublons = array( 'col' => 'email', 'value' => true ); // true -> is accept doublons on col choosed

            // as class
            // $res_populate = Api::addFake($data,$doublons);

            // as instance / object
            $res_populate = $Api->addFake($data,$doublons);

        }

        // -----------------------------------------------------------------------------
        // Delete
        // -----------------------------------------------------------------------------

        if(isset($_POST["ids"]) && isset($_POST["crud"]) && $_POST["crud"]=="delete")
        {
            foreach($_POST["ids"] as $id)
            {
                $result = $Api->delete($id);
                if($result=="FALSE"){
                    array_push($result_array,$result);
                }
            }
        }

        // -----------------------------------------------------------------------------
        // Update
        // -----------------------------------------------------------------------------



        // -----------------------------------------------------------------------------

        if(count($result_array)>0){
            $response = "FALSE";
        }else{$response = "TRUE";}

}

echo $response;

?>