<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

// Register api
// require __DIR__ . '/pagination.class.php';

final class TestApiAction
{
    private $view;
    private $logger;

    public function __construct(Twig $view, LoggerInterface $logger, $db, $Api, $Pagination, $faker, $settings, $tables, $n_results)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
        $this->Api = $Api;
        $this->Pagination = $Pagination;
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





    $limit = 15; 
    if(isset($_GET['n_results'])){$limit = $_GET['n_results']; }

    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $limit_start = ($page - 1) * $limit;
    // $datas = select_table($pdo, $table, $limit_start, $limit);
    // $rows_count = rows_count($pdo, $table);
        $table_fetchAll = $Api->select($limit_start,$n_results_get);











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
            







        // pagination
        // $pgn_url       = $_SERVER["PHP_SELF"];
        $pgn_url       = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $pgn_limit     = $limit; // n results
        $pgn_rowsCount = count($Api->select_all()); 
        $pgn_getPage   = 'page'; // url var
        $pgn_getResult = 'n_results'; // url var
        $pgn_nBtns = 4;  // tot max visible btn = n*2 +1 (without first and last)
        $pgn_icons     = array("icon_before"=>"&#60;","icon_etc"=>"...","icon_next"=>"&#62;"); // before, next, ...
        // // DONT CHANGE
        $pgn_page      = (isset($_GET[$pgn_getPage])) ? $_GET[$pgn_getPage] : 1;
        // if(isset($_GET[$pgn_getResult])){$pgn_limit = $_GET[$pgn_getResult]; }


        // echo $pgn_url;
        echo "<br><br><br><br><br><br><br>";
        // print_r($pgn_rowsCount) ;

        $Pagination = new $this->Pagination($pgn_url,$pgn_limit,$pgn_rowsCount,$pgn_nBtns,$pgn_icons,$pgn_page,$pgn_getResult);

        $viewData = [
            // tests var
            'now' => date('Y-m-d H:i:s'),
            'res_test'=> $testConnectApi,
            // table
            'table' => $table,
            'tables' => $this->tables,

            'n_results' => $n_results_get,
            'n_results_default' => $this->n_results_default,
            'n_results_array' => $this->n_results_array,

            'table_fetchAll' => $table_fetchAll,
            'fake' => $check_fake,
            // pagination
            'pagination' => $Pagination
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }
}
