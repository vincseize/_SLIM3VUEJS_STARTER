<?php

// $settings = require __DIR__ . '/settings.php';

// print_r($settings);


$result = array();

if(isset($_POST["ids"]))
{
    $host = $_POST["host"];
    $dbname = $_POST["dbname"];
    $user = $_POST["user"];
    $passwd = $_POST["passwd"];

    $table = $_POST["table"];

    $db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname,$user, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    foreach($_POST["ids"] as $id)
    {
        $sql = "DELETE FROM $table WHERE id = '".$id."'";
        $sth = $db->prepare($sql);

        if(!$sth->execute()) {
            array_push($result, "FALSE");
        }
    }
}

if(count($result)>0){
    $response = "FALSE";
}else{$response = "TRUE";}

echo $response;

?>