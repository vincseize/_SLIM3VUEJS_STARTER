<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;

// Login (get JWT token)
$app->post('/api/token', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    // - TODO : Faire un vrai check de l'utilisateur (pseudo + mot de passe) en BDD
    // et récupérer les vraies données de cet utilisateur
    $user = [
        'id' => 1,
        'pseudo' => $data['pseudo'],
        'firstName' => 'Démoe',
        'lastName' => 'Testing',
        'email' => 'demo@testing.org'
    ];

    // - Durée de validité du token (en heure) => à mettre dans la config root (/app_settings.json)
    $tokenDuration = 4;

    // - Phrase secrète du token (salt) => à mettre dans la config root
    $tokenSecretKey = 'UneSuperChaîneSecrèteÀMettreDansLaConfig';

    $now = new DateTime();
    $expires = new DateTime(sprintf('now +%d hours', $tokenDuration));
    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $expires->getTimeStamp(),
        "user" => $user
    ];

    $token = JWT::encode($payload, $tokenSecretKey, 'HS256');

    $responseData = [
        'user'  => $user,
        'token' => $token
    ];

    return $response->withJson($responseData);
});
