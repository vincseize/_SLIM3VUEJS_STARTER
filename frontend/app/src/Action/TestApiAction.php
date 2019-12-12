<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

// Register api
// require __DIR__ . '/../api.class.php';

final class TestApiAction
{
    private $view;
    private $logger;

    public function __construct(Twig $view, LoggerInterface $logger, $db, $Api, $faker)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
        $this->Api = $Api;
        $this->faker = $faker;
        // $this->Api_clients = $Api_clients;
        

    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->logger->info("Hello page action dispatched");
        
        // $table='clients';
        // $api = new Api($this->db,$table);
        // $faker = Faker\Factory::create();

        $Api_clients = new $this->Api($this->db,'clients');
        $faker = $this->faker;


        $res_test = $Api_clients->testConnectApi();
        // $res_test = $this->db->testConnectApi();


        $viewData = [
            'now' => date('Y-m-d H:i:s'),
            'hello' => 'hella'
        ];
    
        // return $this->get(Twig::class)->render($response, 'time.twig', $viewData);

        $this->view->render($response, 'hello.twig', $viewData);
        return $response;
    }
}
