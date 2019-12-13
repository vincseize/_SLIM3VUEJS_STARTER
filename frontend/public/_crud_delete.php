<?php
//delete.php
$host = "localhost";
$dbname = "booking_vuejs";
$user = "root";
$passwd = "";
$table = "clients";
$pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbname,$user, $passwd);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$result = array();

if(isset($_POST["ids"]))
{
    foreach($_POST["ids"] as $id)
    {
        $sql = "DELETE FROM $table WHERE id = '".$id."'";
        $sth = $pdo->prepare($sql);

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