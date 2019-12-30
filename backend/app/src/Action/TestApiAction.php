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
        // $db, $Pagination, $faker, $settings, $tables, $n_results
        $db, $Api, $Pagination, $faker, $settings, $tables, $n_results
    ) {
        $this->view = $_view;
        $this->logger = $_logger;
        $this->db = $db;
        $this->Api = $Api;
        $this->Pagination = $Pagination;
        $this->faker = $faker;
        $this->settings = $settings;
        $this->table = explode('?', basename($_SERVER['REQUEST_URI']))[0];
        $this->tables = $tables;
        $this->n_results_array = $n_results['n_results_array'];
        $this->n_results_default = $n_results['n_results_default'];
        $this->url = dirname(dirname(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)));
        $this->url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->url;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        // table vars
        $url_getPage   = 'page'; // url var
        $url_getResult = 'n_result'; // url var

        $n_results_get = $this->n_results_default;
        if ($request->getQueryParams() ) {
            $gets = $request->getQueryParams();
            $n_results_get = $gets[$url_getResult];
        }

        $file = pathinfo(basename(__FILE__));
        $filename = lcfirst($file['filename']);
        $dirname =  basename(dirname(__FILE__));
        $trimmed = str_replace($dirname, '', $filename) ;
        // $url_form = $this->url."/".$trimmed."/".$this->table."?".$url_getPage."=1&".$url_getResult."=".$n_results_get."";
        $url_form = $this->url."/".$trimmed."/".$this->table."";
        $Api = new $this->Api($this->db, $this->table);
        $tableColsNames = $Api->tableColsName();
        

        if(isset($_GET['submit_add'])) { 
            // return;
            $url = $this->url."/api/".$this->table;
            $get_false = [$url_getPage, $url_getResult, "submit_add", "chck_fake"];
            $doublons = array( 'col' => 'email', 'value' => true ); // true -> is accept doublons on col choosed
            $Api->add_restful($url, $doublons, $_GET, $url_getPage, $url_getResult, $n_results_get, $get_false);
            // $url,$doublons,$get,$url_getPage,$n_results_get

            // $post = array();
            // foreach ( $_GET as $key => $value ) 
            // {
            //     if(!in_array($key,$get_false)){
            //         $post[$key] = $_GET[$key];
            //     }
            // }
    
            // $fieldsList = $Api->getBinds($post)[0];
            // $bindsList = $Api->getBinds($post)[1];

            // // Order Important, post_data at least
            // $post["post_data"] = $post;
            // $post["bindsList"] = $fieldsList;
            // $post["fieldsList"] = $bindsList;
    

            // $url = $this->url."/api/".$this->table;
            // $data = json_encode($post);
            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // $response = curl_exec($ch);
            // curl_close($ch);          
            // $data = json_decode($response,true);
            // $location = $url_form."?".$url_getPage."=1&".$url_getResult."=".$n_results_get."&message=".$data['message']."";       
            // header("Location: $location"); 
            // exit();

            return;
        }
        
    
        // --------------------------------------------------


        $this->logger->info("Hello page action dispatched");

        // $n_results_get = $this->n_results_default;
        // if ($request -> getQueryParams() ) {
        //     $gets = $request->getQueryParams();
        //     $n_results_get = $gets[$url_getResult];
        // }

        

        // $Api = new $this -> Api($this -> db, $this->table);
        $testConnectApi='FALSE';
        $testConnectApi = $Api->testConnectApi();

        // $url_getPage   = 'page'; // url var
        // $url_getResult = 'n_result'; // url var
        $n_results_get = $this->n_results_default;
        if ($request -> getQueryParams() ) {
            $gets = $request->getQueryParams();
            $n_results_get = $gets[$url_getResult];
        }

        $rowsCount = count($Api->select_all()); 
        $limit_deflt = $this->n_results_default; 
        $limit = $limit_deflt; 
        if (isset($_GET[$url_getResult]) ) {
            $limit = $_GET[$url_getResult]; 
        } 
        if(!isset($_GET[$url_getResult]) || trim($_GET[$url_getResult]) === ""){$limit = $limit_deflt;}
        // echo $limit;
        // return;
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

        // vars for twig templates
        $viewData = [
            // tests vars
            'now' => date('Y-m-d H:i:s'),
            'res_test'=> $testConnectApi,
            // table vars
            'fake' => $check_fake,
            'table_fetchAll' => $table_fetchAll,
            'tableColsNames' => $tableColsNames,
            'table' => $this->table,
            'tables' => $this->tables,
            'n_results' => $pgn_page,
            'page' => $n_results_get,
            'n_result' => $n_results_get,
            'n_results_default' => $this->n_results_default,
            'n_results_array' => $this->n_results_array,
            'pgn_paramPage'=> $pgn_paramPage,
            'pgn_paramRes'=> $pgn_paramRes,
            'pgn_dfltLimit' => $pgn_dfltLimit,
            'url_form' => $url_form,
            'rowsCount' => $rowsCount,
            // pagination
            'pagination' => $pagination,
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }




}