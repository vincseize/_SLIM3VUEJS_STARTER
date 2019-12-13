toto
<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = '';
$config['db']['dbname'] = 'booking_vuejs';


$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();

// $mapper = new ClientsMapper($this->db);
$app->get('/clients', function (Request $request, Response $response) {
    $this->logger->addInfo("Ticket list");
    $mapper = new ClientsMapper($this->db);
    $tickets = $mapper->getClients();

    $response->getBody()->write(var_export($tickets, true));
    return $response;
});

// $app->get('/clients/{id}', function (Request $request, Response $response, $args) {
//     $this->logger->addInfo("Ticket list");
//     $mapper = new TicketMapper($this->db);
//     $clients = $mapper->getClients();

//     $response->getBody()->write(var_export($clients, true));
//     return $response;
// })->setName('clients-detail');

$response = $this->view->render($response, 'clients.phtml', ['clients' => $clients, 'router' => $this->router]);





// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });
$app->run();

