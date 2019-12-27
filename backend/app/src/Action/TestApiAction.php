<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class TestApiAction
{
    private $_view;
    private $_logger;

    public function __construct(Twig $_view, LoggerInterface $_logger, 
        $db, $Api, $Pagination, $faker, $settings, $tables, $n_results
    ) {
        $this->view = $_view;
        $this->logger = $_logger;
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
        
        // table vars
        $table = explode('?', basename($_SERVER['REQUEST_URI']))[0];

        $Api = new $this -> Api($this -> db, $table);
        $testConnectApi='FALSE';
        $testConnectApi = $Api->testConnectApi();

        $url_getPage   = 'page'; // url var
        $url_getResult = 'n_result'; // url var
        $n_results_get = $this->n_results_default;
        if ($request -> getQueryParams() ) {
            $gets = $request->getQueryParams();
            $n_results_get = $gets[$url_getResult];
        }

        $rowsCount = count($Api->select_all()); 
        $limit = 15; 
        if (isset($_GET[$url_getResult]) ) {
            $limit = $_GET[$url_getResult]; 
        }
        $page = (isset($_GET[$url_getPage])) ? $_GET[$url_getPage] : 1;
        $limit_start = ($page - 1) * $limit;
        $table_fetchAll = $Api -> select($limit_start, $n_results_get);

        $array_fake = array('nom','email');
        $array_cols = array();
        $array_check = array();
        $check_fake = 'FALSE'; // check if cols in table
  
        foreach ($table_fetchAll[0] as $key => $value) {
            array_push($array_cols, $key);
        }

        foreach ($array_fake as $value) {
            if (!in_array($value, $array_cols)) {
                array_push($array_check, 'FALSE');
            }
        }

        if (count($array_check)==0) {
            $check_fake = 'TRUE'; // check if cols in table
        }

        // table pagination vars
        $pgn_dfltLimit  = $limit; 
        $pgn_rCount     = $rowsCount;
        $pgn_paramPage  = $url_getPage; 
        $pgn_paramRes   = $url_getResult; 
        $pgn_nBtns      = 4; 
        $pgn_ics        = array(
            "icon_before"=>"&#60;", 
            "icon_etc"=>"...", 
            "icon_next"=>"&#62;"
        );

        $pgn_page      = (isset($_GET[$pgn_paramPage])) ? $_GET[$pgn_paramPage] : 1;
        if(isset($_GET[$pgn_paramRes])){$pgn_dfltLimit = $_GET[$pgn_paramRes]; }

        $Pagination = new $this -> Pagination(
            $pgn_page,
            $pgn_dfltLimit,
            $pgn_rCount,
            $pgn_nBtns,
            $pgn_ics,
            $pgn_paramPage,
            $pgn_paramRes,
            "TRUE"
        );

        $pagination = $Pagination->pagination_ui();
        // $pagination = $Pagination->li_start();
        // $pagination .= $Pagination->number_page_prev();
        // $pagination .= $Pagination->number_first_page();
        // $pagination .= $Pagination->number_etc_page_begin();
        // $pagination .= $Pagination->number_page();
        // $pagination .= $Pagination->number_etc_page_end();
        // $pagination .= $Pagination->number_end_page();
        // $pagination .= $Pagination->number_page_next();
        // $pagination .= $Pagination->li_end();

        $viewData = [
            // tests vars
            'now' => date('Y-m-d H:i:s'),
            'res_test'=> $testConnectApi,
            // table vars
            'fake' => $check_fake,
            'table_fetchAll' => $table_fetchAll,
            'table' => $table,
            'tables' => $this -> tables,
            'n_results' => $n_results_get,
            'n_results_default' => $this -> n_results_default,
            'n_results_array' => $this -> n_results_array,
            'pgn_paramPage'=> $pgn_paramPage,
            'pgn_paramRes'=> $pgn_paramRes,
            // pagination
            'pagination' => $pagination,
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }
}