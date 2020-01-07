<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
$table = "clients";

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All
$app->get('/api/clients', function(Request $request, Response $response){
    $sql = "SELECT * FROM clients ORDER by id DESC";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($clients);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single
$app->get('/api/clients/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM clients WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $client = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($client);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add
$app->post('/api/clients/add', function(Request $request, Response $response){
    $nom = $request->getParam('nom');
    $email = $request->getParam('email');

    $sql = "INSERT INTO clients (nom,email) VALUES
    (:nom,:email)";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        echo '{"notice": {"text": "client Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update
$app->put('/api/clients/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $nom = $request->getParam('nom');
    $email = $request->getParam('email');

    $sql = "UPDATE clients SET
				nom 	= :nom,
                email	= :email
			WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        echo '{"notice": {"text": "Client Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete
$app->delete('/api/clients/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM clients WHERE id = $id";

    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Client Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});