<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Config\DB;

$table = 'clients';

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
$app->get('/api/clients', function (Request $request, Response $response) {
    $sql = "SELECT * FROM clients ORDER by id DESC";

    try {
        $db = new DB();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
    } catch (PDOException $e) {
        $data = ['error' => ['text' => $e->getMessage()]];
    }

    return $response->withJson($data);
});

// Get Single
$app->get('/api/clients/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM clients WHERE id = $id";

    try {
        $db = new DB();
        $db = $db->connect();

        $stmt = $db->query($sql);
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
    } catch (PDOException $e) {
        $data = ['error' => ['text' => $e->getMessage()]];
    }

    return $response->withJson($data);
});

// Add
$app->post('/api/clients/add', function (Request $request, Response $response) {
    $nom = $request->getParam('nom');
    $email = $request->getParam('email');

    $sql = "INSERT INTO clients (nom,email) VALUES (:nom,:email)";

    try {
        $db = new DB();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = ['notice' => ['text' => "Client added"]];
    } catch (PDOException $e) {
        $data = ['error' => ['text' => $e->getMessage()]];
    }

    return $response->withJson($data);
});

// Update
$app->put('/api/clients/update/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nom = $request->getParam('nom');
    $email = $request->getParam('email');

    $sql = "UPDATE clients SET
				nom   = :nom,
                email = :email
			WHERE id = $id";

    try {
        $db = new DB();
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $data = ['notice' => ['text' => "Client updated"]];
    } catch (PDOException $e) {
        $data = ['error' => ['text' => $e->getMessage()]];
    }

    return $response->withJson($data);
});

// Delete
$app->delete('/api/clients/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM clients WHERE id = $id";

    try {
        $db = new DB();
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;

        $data = ['notice' => ['text' => "Client deleted"]];
    } catch (PDOException $e) {
        $data = ['error' => ['text' => $e->getMessage()]];
    }

    return $response->withJson($data);
});
