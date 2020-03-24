<?php
// ------------------------------------------------------
// -
// -    ALL ROUTES
// -
// -    IMPORTANT: In relation with dependencies.php
// -
// ------------------------------------------------------

$app->get('/', App\Action\HomeAction::class)
    ->setName('homepage');

$app->get('/testApi/[{table}]', App\Action\TestApiAction::class)
    ->setName('testApi');

// API CRUD RESTFUL

// ------------------ READ get

// Get all results
$app->get('/api/[{table}]', function ($request, $response, $args) {
    $sql = "SELECT * FROM ".$args['table']." ORDER BY id";
    $sth = $this->db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// Get with id
$app->get('/api/{table}/[{id}]', function ($request, $response, $args) {
    $sql = "SELECT * FROM ".$args['table']." WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});

// Get with given search term
$app->get('/api/{table}/search/{col}/[{value}]', function ($request, $response, $args) {
    $sql = "SELECT * FROM ".$args['table']." WHERE ".$args['col']." LIKE :value ORDER BY ".$args['col']."";
    $sth = $this->db->prepare($sql);
    $query = "%".$args['value']."%";
    $sth->bindParam("value", $query);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// ------------------ CREATE post

// Add restful basic
// $app->post('/api/restful/clients', function ($request, $response) {
//     $input = $request->getParsedBody();
//     $sql = "INSERT INTO clients (nom) VALUES (:nom)";
//     $sth = $this->db->prepare($sql);
//     $sth->bindParam("nom", $input['nom']);
//     $sth->execute();
//     $input['id'] = $this->db->lastInsertId();
//     return $this->response->withJson($input);
// });

// Add
$app->post('/api/[{table}]', function ($request, $response, $args) {
    $data = json_decode($request->getBody(), true);
    $sql = "INSERT INTO ".$args['table']." (".$data['bindsList'].") VALUES (".$data['fieldsList'].")";
    $sth = $this->db->prepare($sql);
    if ($sth->execute($data["post_data"])) {
        $array['message'] = 'true';
    } else {
        $array['message'] = 'false';
    }
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($array));
});

// ------------------ UPDATE put
// Update restful basic
// $app->put('/api/restful/{table}/update/[{id}]', function ($request, $response, $args) {
//     $input = $request->getParsedBody();
//     $sql = "UPDATE ".$args['table']." SET nom=:nom WHERE id=:id";
//     $sth = $this->db->prepare($sql);
//     $nom = $input['nom'];
//     $sth->bindParam("id", $args['id']);
//     $sth->bindParam("nom", $nom);
//     $sth->execute();
//     $input['id'] = $args['id'];
//     return $this->response->withJson($input);
// });

// Update by form
$app->put('/api/{table}/update/[{id}]', function ($request, $response, $args) {
    $data = json_decode($request->getBody(), true);
    $set_values = "";
    $exec_array = [];
    foreach ($data["post_data"] as $key => $value) {
        $set_values .= $set_values." ".$key."=".":".$key.", ";
        $exec_array[":".$key] = $value;
    }
    $set_values = rtrim($set_values, ", ");
    $exec_array[":id"] = $args['id'];
    $sql = "UPDATE ".$args['table']." SET $set_values WHERE id= :id";
    $sth = $this->db->prepare($sql);
    if ($sth->execute($exec_array)) {
        $array['message'] = 'true';
    } else {
        $array['message'] = 'false';
    }
    return $response->withStatus(200)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($array));
});

// ------------------------------------ Others Samples

// ------------------ DELETE delete

// Delete restful basic by id
// $app->delete('/api/{table}/delete/[{id}]', function ($request, $response, $args) {
//     $result = 0;
//     $sql = "DELETE FROM ".$args['table']." WHERE id=".$args['id']."";
//     $sth = $this->db->prepare($sql);
//     $sth->bindParam("id", $args['id']);
//     // $sth->execute();
//     if($sth->execute()){
//         $array['message'] = 'true';
//     }else{
//         $array['message'] = 'false';
//     }
//     return $response->withStatus(200)
//     ->withHeader("Content-Type","application/json")
//     ->write(json_encode($array));
// });

// ------------------ Add create json file

// $app->post('/api/clients', function($request, $response){
//     $datajson = array();
//     $data = json_decode($request->getBody(),true);
//     $datajson[] = $data;
//     $fp = fopen('data.json', 'w');
//     fwrite($fp, json_encode($datajson));
//     fclose($fp);

//     $array['status'] = '200';
//     $array['message'] = 'register success';
//     $array['data']= array("islogin"=>false);
//     return $response->withStatus(200)
//     ->withHeader("Content-Type","application/json")
//     ->write(json_encode($array));
//    });
