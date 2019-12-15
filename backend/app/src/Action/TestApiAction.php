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

    public function __construct(Twig $view, LoggerInterface $logger, $db, $Api, $faker, $settings, $tables)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
        $this->Api = $Api;
        $this->faker = $faker;
        $this->settings = $settings;
        $this->tables = $tables;

    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->logger->info("Hello page action dispatched");
        
        $table=basename($_SERVER['REQUEST_URI']);
        $Api = new $this->Api($this->db,$table);
        $faker = $this->faker;

        $testConnectApi='FALSE';
        $testConnectApi = $Api->testConnectApi();

        // $data = array( 
        //     'nom' => htmlspecialchars($faker->name), 
        //     'email' => htmlspecialchars($faker->email) 
        // );
        // $doublons = array( 'col' => 'email', 'value' => true );

        $table_fetchAll = $Api->selectTest();


        $viewData = [
            'now' => date('Y-m-d H:i:s'),
            'res_test'=> $testConnectApi,

            'table' => $table,
            'tables' => $this->tables,

            'table_fetchAll' => $table_fetchAll


            // 'Api' => $this->db
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }
}
