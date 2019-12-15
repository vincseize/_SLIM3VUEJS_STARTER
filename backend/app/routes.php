<?php

// ROUTES

// use Slim\Views\Twig;
// IMPORTANT : In relation with dependencies.php

$app->get('/', App\Action\HomeAction::class)
    ->setName('homepage');

$app->get('/time', App\Action\TimeAction::class)
    ->setName('time');
    
$app->get('/hello', App\Action\HelloAction::class)
    ->setName('hello');

$app->get('/testApi/[{table}]', App\Action\TestApiAction::class)
    ->setName('testApi');

// --------------------------------

$app->get('/api/test', function ($request, $response, $args) {

    $table='clients';
    $api = new Api($this->db,$table);
    $faker = Faker\Factory::create();
    
    // as class
    // $res_test = Api::test();

    // as instance / object
    $res_test = $api->testConnectApi();


    // ----- SAMPLE FOR DOUBLONS UNAUTHORIZE, 'value' => false
    // $data = array( 
    //     'nom' => htmlspecialchars($faker->name), 
    //     'email' => 'toto' 
    // );
    // $doublons = array( 'col' => 'email', 'value' => false );
    // -------------------------------------

    $data = array( 
        'nom' => htmlspecialchars($faker->name), 
        'email' => htmlspecialchars($faker->email) 
    );
    $doublons = array( 'col' => 'email', 'value' => true );

    // as class
    // $res_populate = Api::populate($data,$doublons);

    // as instance / object
    $res_populate = $api->populate($data,$doublons);
    echo $res_populate;

    return;

});

// API CRUD RESTFUL

// ------------------ READ get

// Get all results
// $app->get('/api/clients', function ($request, $response, $args) {
$app->get('/api/[{table}]', function ($request, $response, $args) {
    $sql = "SELECT * FROM ".$args['table']." ORDER BY id";
    $sth = $this->db->prepare($sql);
    // $sth = $this->db->prepare("SELECT * FROM clients ORDER BY id");
    $sth->execute();
    $result = $sth->fetchAll();
    // print_r($request);
    return $this->response->withJson($result);
});

// Get result with id
// $app->get('/api/clients/[{id}]', function ($request, $response, $args) {
$app->get('/api/{table}/[{id}]', function ($request, $response, $args) {
    // $sql = "SELECT * FROM clients WHERE id=:id";
    $sql = "SELECT * FROM ".$args['table']." WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});
	
// Get result with given search term
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

// Add
$app->post('/api/clients', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO clients (nom) VALUES (:nom)";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("nom", $input['nom']);
    $sth->execute();
    $input['id'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
});

// ------------------ UPDATE put

// Update
$app->put('/api/clients/update/{id}/[{nom}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE clients SET nom=:nom WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("nom", $args['nom']);
    $sth->execute();
    $input['id'] = $args['id'];
    return $this->response->withJson($input);
});

// Update by form
// $app->put('/api/clients/update/[{id}]', function ($request, $response, $args) {
//     $input = $request->getParsedBody();
//     $sql = "UPDATE clients SET nom=:nom WHERE id=:id";
//     $sth = $this->db->prepare($sql);
//     $sth->bindParam("id", $args['id']);
//     $sth->bindParam("nom", $input['nom']);
//     $sth->execute();
//     $input['id'] = $args['id'];
//     return $this->response->withJson($input);
// });

// ------------------ DELETE delete
	
// Delete by id
$app->delete('/api/{table}/delete/[{id}]', function ($request, $response, $args) {
    $result = 0;
    $sql = "DELETE FROM ".$args['table']." WHERE id=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->rowCount();
    return $this->response->withJson($result);
});
