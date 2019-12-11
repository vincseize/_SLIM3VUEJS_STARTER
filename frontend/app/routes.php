<?php

// ROUTES

// use Slim\Views\Twig;

$app->get('/', App\Action\HomeAction::class)
    ->setName('homepage');

$app->get('/time', App\Action\TimeAction::class)
    ->setName('time');
    
$app->get('/hello', App\Action\HelloAction::class)
    ->setName('hello');

$app->get('/api/test', function ($request, $response, $args) {

    $table='clients';
    $api = new Api($this->db,$table);
    $faker = Faker\Factory::create();
    
    // as class
    // $res_test = Api::test();

    // as instance / object
    $res_test = $api->testApi();


    // ----- SAMPLE FOR DOUBLONS UNAUTHORIZE
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

// get all result
$app->get('/api/clients', function ($request, $response, $args) {
    $stmt = $this->db->prepare("SELECT * FROM clients ORDER BY id");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $this->response->withJson($result);
});

// Retrieve todo with id 
$app->get('/api/clients/[{id}]', function ($request, $response, $args) {
    $stmt = $this->db->prepare("SELECT * FROM clients WHERE id=:id");
    $stmt->bindParam("id", $args['id']);
    $stmt->execute();
    $result = $stmt->fetchObject();
    return $this->response->withJson($result);
});
	
// Search with given search term
$app->get('/api/clients/search/[{query}]', function ($request, $response, $args) {
    $stmt = $this->db->prepare("SELECT * FROM clients WHERE nom LIKE :query ORDER BY nom");
    $query = "%".$args['query']."%";
    $stmt->bindParam("query", $query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $this->response->withJson($result);
});

// ------------------ CREATE post

// Add
$app->post('/api/clients', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO clients (client) VALUES (:client)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam("nom", $input['nom']);
    $stmt->execute();
    $input['id'] = $this->db->lastInsertId();
    return $this->response->withJson($input);
});

// ------------------ UPDATE put

// Update
$app->put('/api/clients/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE clients SET nom=:nom WHERE id=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam("id", $args['id']);
    $stmt->bindParam("nom", $input['nom']);
    $stmt->execute();
    $input['id'] = $args['id'];
    return $this->response->withJson($input);
});

// ------------------ DELETE delete
	
// Delete
$app->delete('/api/clients/[{id}]', function ($request, $response, $args) {
    $stmt = $this->db->prepare("DELETE FROM clients WHERE id=:id");
    $stmt->bindParam("id", $args['id']);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $this->response->withJson($result);
});
