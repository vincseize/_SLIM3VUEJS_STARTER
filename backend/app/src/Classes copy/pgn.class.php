<?php

    class Pagination
    {
        public $pgn_limit;
        public $pgn_rCount;
        public $pgn_nBtns;
        public $pgn_ics;
        public $pgn_page;
        public $pgn_paramPage;
        public $pgn_paramRes;
        
        public $pgn_nPages;
        public $pgn_startNb;
        public $pgn_endNb;
        public $pgn_url;
        public $pgn_sep;

    public function __construct($pgn_page,$pgn_limit,$pgn_rCount,$pgn_nBtns,$pgn_ics,$pgn_paramPage,$pgn_paramRes,$twig="FALSE"){
            $this->pgn_url        = $_SERVER["REQUEST_URI"];
            $this->pgn_sep        = "&";
            parse_str($_SERVER['QUERY_STRING'], $output);
            if (count($output, COUNT_NORMAL) == 0 ) {
                $this->pgn_sep = "?";
            }
            $this->pgn_page       = $pgn_page;
            $this->pgn_limit      = $pgn_limit;
            $this->pgn_rCount     = $pgn_rCount;
            $this->pgn_nPages     = ceil($this -> pgn_rCount / $this -> pgn_limit);
            $this->pgn_paramPage  = $pgn_paramPage;
            $this->pgn_paramRes   = $pgn_paramRes;
            $this->pgn_nBtns      = $pgn_nBtns;
            $this->pgn_startNb    = ($this->pgn_page > $this->pgn_nBtns) ? $this->pgn_page - $this->pgn_nBtns : 1;
            $this->pgn_endNb      = ($this->pgn_page < ($this->pgn_nPages - $this->pgn_nBtns)) ? $this->pgn_page + $this->pgn_nBtns : $this->pgn_nPages;
            $this->pgn_iconBefore = $pgn_ics['icon_before'];
            $this->pgn_iconEtc    = $pgn_ics['icon_etc'];
            $this->pgn_iconNext   = $pgn_ics['icon_next'];
            $this->pgn_btn_clDis  = " class='disabled'";
            $this->pgn_btn_clEna  = " class='active'";

            $pagination = $this->pagination_ui();
            if($twig=="TRUE"){return $pagination;}else{echo $pagination;}
        }

    public function pagination_ui(){
            // Order fcts !important!
            $pagination = $this->li_start();
            $pagination .= $this->number_page_prev();
            $pagination .= $this->number_first_page();
            $pagination .= $this->number_etc_page_begin();
            $pagination .= $this->number_page();
            $pagination .= $this->number_etc_page_end();
            $pagination .= $this->number_end_page();
            $pagination .= $this->number_page_next();
            $pagination .= $this->li_end();
            return $pagination;
        }

    /** 
     * Remove a query string parameter from an URL.
     *
     * Comment
     * 
     * @param string $url
     * @param string $param
     *
     * @return string
     */
    public function removeUrlParam($url, $param)
        {
            if (isset($_GET[$param]))
            {
                $parseUri = parse_url($url);
                $arrayUri = array();
                parse_str($parseUri['query'], $arrayUri);
                unset($arrayUri[$param]);
                $newUri = http_build_query($arrayUri);
                $url = $parseUri['path'].'?'.$newUri;
            }
            return $url;
        }

        public function pagination_link($link_active, $class_disabled, $page_li, $number){
            $url = $this->removeUrlParam($this->pgn_url, $this->pgn_paramPage);
            $url = $this->removeUrlParam($url, $this->pgn_paramRes);
            $url = $url.$this->pgn_sep.$this->pgn_paramPage."=".$page_li."&".$this->pgn_paramRes."=".$this->pgn_limit;
            $link = "<li $link_active $class_disabled><a href='$url'>$number</a></li>";
            return $link;
        }

        public function number_page_prev(){
            $link_active = '';
            $link_prev = ($this->pgn_page > 1) ? $this->pgn_page - 1 : 1;
            if ($this->pgn_page == 1) { 
                $class_disabled = $this->pgn_btn_clDis; 
                if($this->pgn_rCount==0){$class_disabled = $this->pgn_btn_clDis;}
            } else { 
                $class_disabled = '';
                if($this->pgn_rCount==0){$class_disabled = $this->pgn_btn_clDis;}
            }
            $li = $this->pagination_link($link_active, $class_disabled, $link_prev, $this->pgn_iconBefore);
            return $li;
        }

        public function number_first_page(){
            if($this->pgn_page==1){$link_active = $this->pgn_btn_clEna;}else{$link_active = '';}
            $class_disabled = '';
            $li = $this->pagination_link($link_active, $class_disabled, 1, 1);
            return $li;
        }

        public function number_etc_page_begin(){
            $link_active = '';
            $class_disabled = '';
            $start_number_minus1 = $this->pgn_startNb-1;
            if ($this->pgn_startNb+1 >= $this->pgn_nBtns) { 
                $li = $this->pagination_link($link_active, $class_disabled, $start_number_minus1, $this->pgn_iconEtc);
                return $li;
            }
        }

        public function number_page(){
            $class_disabled = '';
            $li = '';
            if($this->pgn_rCount!=0 && $this->pgn_rCount>$this->pgn_limit){
                for ($i = $this->pgn_startNb; $i <= $this->pgn_endNb; $i++) {
                    $link_active = ($this->pgn_page == $i) ? $this->pgn_btn_clEna : '';
                    if ($i != '1' && $i != $this->pgn_nPages) {
                        // $link_active = $this->pgn_btn_clEna;
                        $li .= $this->pagination_link($link_active, $class_disabled, $i, $i);
                    }
                }
                return $li;
            }
        }

        public function number_etc_page_end(){
            $class_disabled = '';
            if($this->pgn_page==$this->pgn_nPages){$link_active = $this->pgn_btn_clEna;}
            $end_number_max1 = $this->pgn_endNb+1;
            if ($end_number_max1 < $this->pgn_nPages) {
                $link_active = '';
                $li = $this->pagination_link($link_active, $class_disabled, $end_number_max1, $this->pgn_iconEtc);
                return $li;
            }
        }

        public function number_end_page(){
            if($this->pgn_rCount!=0 && $this->pgn_rCount>$this->pgn_limit){
                $class_disabled = '';
                if($this->pgn_page==$this->pgn_nPages){$link_active = $this->pgn_btn_clEna;}else{$link_active = '';}
                $li = $this->pagination_link($link_active, $class_disabled, $this->pgn_nPages, $this->pgn_nPages);
                return $li;
            }
        }

        public function number_page_next(){
            $link_next = ($this->pgn_page < $this->pgn_nPages) ? $this->pgn_page + 1 : $this->pgn_nPages;
            if ($this->pgn_page == $this->pgn_nPages) {
                $link_active = '';
                $class_disabled = $this->pgn_btn_clDis;  
                if($this->pgn_rCount==0){$class_disabled = $this->pgn_btn_clDis;}
            } else {
                $link_active = '';
                $class_disabled = '';
                if($this->pgn_rCount==0){$class_disabled = $this->pgn_btn_clDis;}
            }
            $li = $this->pagination_link($link_active, $class_disabled, $link_next, $this->pgn_iconNext);
            return $li;
        }

        public function li_start(){
            $li  = "<ul class='pagination'>";
            return $li;
        }

        public function li_end(){
            $li = "</ul>";
            return $li;
        }
    }
?>