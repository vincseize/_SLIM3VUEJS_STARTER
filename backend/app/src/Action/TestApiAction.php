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

    public function __construct(Twig $view, LoggerInterface $logger, $db, $Api, $faker, $settings, $tables, $n_results)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
        $this->Api = $Api;
        $this->faker = $faker;
        $this->settings = $settings;
        $this->tables = $tables;
        $this->n_results_array = $n_results['n_results_array'];
        $this->n_results_default = $n_results['n_results_default'];
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $this->logger->info("Hello page action dispatched");
        
        $table = explode('?', basename($_SERVER['REQUEST_URI']))[0];

        $Api = new $this->Api($this->db,$table);
        $testConnectApi='FALSE';
        $testConnectApi = $Api->testConnectApi();

        $n_results_get = $this->n_results_default;
        if($request->getQueryParams()){
            $gets = $request->getQueryParams();
            $n_results_get = $gets['n_results'];
        }

        $table_fetchAll = $Api->select($n_results_get);

        $array_fake = array('nom','email');
        $array_cols = array();
        $array_check = array();
        $check_fake = 'FALSE';
  
        foreach ($table_fetchAll[0] as $key => $value){
            array_push($array_cols, $key);
        }

        foreach ($array_fake as $value){
            if (!in_array($value, $array_cols)) {
                array_push($array_check, 'FALSE');
            }
        }

        if(count($array_check)==0){
            $check_fake = 'TRUE';
        }
            
        $viewData = [
            'now' => date('Y-m-d H:i:s'),
            'res_test'=> $testConnectApi,

            'table' => $table,
            'tables' => $this->tables,

            'n_results' => $n_results_get,
            'n_results_default' => $this->n_results_default,
            'n_results_array' => $this->n_results_array,

            'table_fetchAll' => $table_fetchAll,
            'fake' => $check_fake
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }
}
