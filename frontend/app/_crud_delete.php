<?php




$result_array = array();
$response = "FALSE";

if(isset($_POST["table"])){

// -----------------------------------------------------------------------------


// Register api
require __DIR__ . '/api.class.php';



// $settings = require __DIR__ . '/settings.php';

// -----------------------------------------------------------------------------
// Service database
// -----------------------------------------------------------------------------
    
$host = "localhost";
$dbname = "booking_vuejs";
$user = "root";
$passwd = "";

// PDO database library 
// $container['db'] = function ($c) {
    // $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname,$user, $passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// };


// -----------------------------------------------------------------------------
// Delete
// -----------------------------------------------------------------------------

        if(isset($_POST["ids"]) && isset($_POST["crud"])=="delete")
        {
            $table = $_POST["table"];
            $Api = new Api($pdo,$table);
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