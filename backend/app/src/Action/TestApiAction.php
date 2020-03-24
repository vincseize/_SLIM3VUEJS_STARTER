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

    public function __construct(
        Twig $_view,
        LoggerInterface $_logger,
        // $db, $Pagination, $faker, $settings, $tables, $n_results
        $db,
        $Api,
        $Pagination,
        $faker,
        $settings,
        $tables,
        $n_results
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
        $this->url_getPage   = 'page'; // url var
        $this->url_getResult = 'n_result'; // url var
        $this->get_false = [$this->url_getPage, $this->url_getResult, "submit_add", "submit_update", "get_id", "get_page", "chck_fake"];
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        // table vars
        $url_getPage   = 'page'; // url var
        $url_getResult = 'n_result'; // url var
        $message= 'message'; // url var
        $filter = 'filter'; // url var
        $filter_value = 'filter_value'; // url var
        $order = 'order'; // url var
        $order_by = 'order_by'; // url var
        $date_now = date('Y-m-d H:i:s');

        $order_value = "DESC";
        $n_results_get = $this->n_results_default;
        if ($request->getQueryParams()) {
            $gets = $request->getQueryParams();
            $n_results_get = $gets[$url_getResult];
        }

        $url_form = $this->url."/api/".$this->table;
        $url_form_add = $this->url."/api/".$this->table;
        $url_form_update = "";
        $url = $this->url."/testApi/".$this->table;

        // $file = pathinfo(basename(__FILE__));
        // $filename = lcfirst($file['filename']);
        // $dirname =  basename(dirname(__FILE__));
        // $trimmed = str_replace($dirname, '', $filename) ;
        // $url_form = $this->url."/".$trimmed."/".$this->table."?".$url_getPage."=1&".$url_getResult."=".$n_results_get."";
        // $url_form = $this->url."/".$trimmed."/".$this->table."";
        // $url_form_update = $this->url."/api/".$this->table."/search/id/";
        $Api = new $this->Api($this->db, $this->table);
        $tableColsNames = $Api->tableColsName();
        $tableColsNames_all = $Api->tableColsName_all();
        $first_col = array_keys($tableColsNames_all)[0];
        $dflt_col_search = array_keys($tableColsNames_all)[1];

        $this->logger->info("Api ".$this->table." action dispatched");
        $testConnectApi='FALSE';
        $testConnectApi = $Api->testConnectApi();

        // ORDER
        if (isset($_GET[$order])) {
            $order_value = $_GET[$order];
        }

        $order_by_value = $first_col;
        if (isset($_GET[$order_by])) {
            $order_by_value = $_GET[$order_by];
        }

        // ADD
        if (isset($_GET['submit_add'])) {
            // return;
            // $url_form_add = $this->url."/api/".$this->table;
            // $url = $this->url."/testApi/".$this->table;
            // $get_false = [$url_getPage, $url_getResult, "submit_add", "chck_fake"];
            $doublons = ['col' => 'email', 'value' => true]; // true -> is accept doublons on col choosed
            $Api->add_restful($url, $url_form_add, $doublons, $_GET, $this->url_getPage, $this->url_getResult, $n_results_get, $this->get_false);

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

        /**
         * Remove a query string parameter from an URL.
         *
         * @param string $url
         * @param string $varname
         *
         * @return string
         */
        function removeQueryStringParameter($url, $varname)
        {
            $parsedUrl = parse_url($url);
            $query = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
                unset($query[$varname]);
            }

            $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
            $query = !empty($query) ? '?'. http_build_query($query) : '';

            return $parsedUrl['scheme']. '://'. $parsedUrl['host']. $path. $query;
        }

        function change_url_parameter($url, $parameter, $parameterValue)
        {
            $url=parse_url($url);
            parse_str($url["query"], $parameters);
            unset($parameters[$parameter]);
            $parameters[$parameter]=$parameterValue;
            return  $url["path"]."?".http_build_query($parameters);
        }

        // UPDATE
        if (isset($_GET['submit_update'])) {
            $id = $_GET['get_id'];
            $curPage = $_GET['page'];
            $cur_getPage = $_GET['get_page'];

            $dflt_col_search_value = $_GET[$dflt_col_search];
            $url_reload = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url_changed = change_url_parameter($url_reload, $url_getPage, $cur_getPage);
            $url_reload = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$url_changed."&filter=$dflt_col_search&filter_value=$dflt_col_search_value";

            $url_reload = removeQueryStringParameter($url_reload, 'submit_update');
            $url_reload = removeQueryStringParameter($url_reload, 'get_id');
            $url_reload = removeQueryStringParameter($url_reload, 'get_page');

            $url_form_update = $this->url."/api/".$this->table."/update/".$id."";
            $url = $this->url."/testApi/".$this->table;
            $doublons = ['col' => 'email', 'value' => true]; // true -> is accept doublons on col choosed
            $Api->update_restful($url_reload, $url, $curPage, $url_form_update, $doublons, $_GET, $this->url_getPage, $this->url_getResult, $n_results_get, $this->get_false);
            return;
        }

        if (isset($_GET["delete_ids"])) {
            foreach ($_GET["delete_ids"] as $id) {
                $result = $Api->delete($id);
                if ($result == "FALSE") {
                    array_push($result_array, $result);
                }
            }
            echo json_encode($result_array);
        }

        // READ
        $n_results_get = $this->n_results_default;
        if ($request -> getQueryParams()) {
            $gets = $request->getQueryParams();
            $n_results_get = $gets[$url_getResult];
        }

        $limit_deflt = $this->n_results_default;
        $limit = $limit_deflt;
        if (isset($_GET[$url_getResult])) {
            $limit = $_GET[$url_getResult];
        }
        if (!isset($_GET[$url_getResult]) || trim($_GET[$url_getResult]) === "") {
            $limit = $limit_deflt;
        }

        $page = (isset($_GET[$url_getPage])) ? $_GET[$url_getPage] : 1;
        $limit_start = ($page - 1) * $limit;
        $table_fetchAll = $Api->select($limit_start, $n_results_get, $order_value, $order_by_value);
        $rowsCount = count($Api->select_all($order_by_value));

        // FILTERS
        if (isset($_GET[$filter]) !== '' && isset($_GET[$filter_value]) !== '') {
            if (!empty($_GET[$filter]) && !empty($_GET[$filter_value])) {
                $col = $_GET[$filter];
                $value = $_GET[$filter_value];
                // restful
                // $url_form = $this->url."/api/".$this->table."/search/".$f."/".$f_value."";
                // $url = $this->url."/testApi/".$this->table;
                // $table_fetchAll = $Api->select_filter_restful($url_form, $url, $limit_start, $n_results_get);
                // classical crud select to use DESC ASC ORDER simply
                if ($col == "All Columns") {
                    $table_fetchAll = $Api->select_filter_all($value, $limit_start, $n_results_get);
                    $rowsCount = count($Api->select_filter_all_countAll($value));
                } else {
                    $table_fetchAll = $Api->select_filter($col, $value, $limit_start, $n_results_get, $order_value);
                    $rowsCount = count($Api->select_filter_countAll($col, $value));
                }
            }
        }

        // vars table pagination
        $pgn_dfltLimit = $limit;
        $pgn_rCount    = $rowsCount;
        $pgn_paramPage = $url_getPage;
        $pgn_paramRes  = $url_getResult;
        $pgn_nBtns     = 4;
        $pgn_ics       = [
            "icon_before" => "&#60;",
            "icon_etc"    => "...",
            "icon_next"   => "&#62;"
        ];

        $pgn_page = (isset($_GET[$pgn_paramPage])) ? $_GET[$pgn_paramPage] : 1;
        if (isset($_GET[$pgn_paramRes])) {
            $pgn_dfltLimit = $_GET[$pgn_paramRes];
        }

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
            // vars tests
            'now' => $date_now,
            'res_test'=> $testConnectApi,
            // vars table, form
            'table_fetchAll' => $table_fetchAll,
            'tableColsNames' => $tableColsNames,
            'tableColsNames_all' => $tableColsNames_all,
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
            'filter' => $filter,
            'filter_value' => $filter_value,
            'message' => $message,
            'order' => $order,
            'order_value' => $order_value,
            'order_by' => $order_by,
            'order_by_value' => $order_by_value,
            'url_form' => $url_form,
            'url_form_add' => $url_form_add,
            'url_form_update' => $url_form_update,
            'rowsCount' => $rowsCount,
            // vars pagination
            'pagination' => $pagination,
        ];

        $this->view->render($response, 'testApi.twig', $viewData);
        return $response;
    }
}
