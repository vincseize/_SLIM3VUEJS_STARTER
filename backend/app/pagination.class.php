<?php
    class Pagination
    {
        public $url;
        
        public $limit;
        public $rows_count;
        public $nBtns;
        public $icons;
        public $page;
        public $nResults;
        
        public $nPages;
        public $startNumber;
        public $endNumber;

        // public function __construct(){
        //     $this->url                 = 'url';
        //     return $this->url;
        // }

        public function __construct($url,$limit,$rows_count,$nBtns,$icons,$page,$nResults){
            $this->url                 = $url;
            $this->page                = $page;
            $this->limit               = $limit;
            $this->rows_count          = $rows_count;
            $this->nPages              = ceil($this->rows_count / $this->limit);
            $this->nResults            = $nResults;
            $this->nBtns               = $nBtns;
            $this->startNumber         = ($this->page > $this->nBtns) ? $this->page - $this->nBtns : 1;
            $this->endNumber           = ($this->page < ($this->nPages - $this->nBtns)) ? $this->page + $this->nBtns : $this->nPages;
            $this->icon_before         = $icons['icon_before'];
            $this->icon_etc            = $icons['icon_etc'];
            $this->icon_next           = $icons['icon_next'];
            $this->btn_class_disabled  = " class='disabled'";
            $this->btn_class_enabled   = " class='active'";
            $this->pagination_ui();
        }

        public function pagination_ui(){
            // Order fcts !important!
            $this->number_page_prev();
            $this->number_first_page();
            $this->number_etc_page_begin();
            $this->number_page();
            $this->number_etc_page_end();
            $this->number_end_page();
            $this->number_page_next();
        }

        public function pagination_link($link_active, $class_disabled, $page_li, $number){
            $link = "<li $link_active $class_disabled><a href='$this->url?page=$page_li&$this->nResults=$this->limit'>$number</a></li>";
            echo $link;
        }

        public function number_page_prev(){
            $link_active = '';
            $link_prev = ($this->page > 1) ? $this->page - 1 : 1;
            if ($this->page == 1) { 
                $class_disabled = $this->btn_class_disabled; 
                if($this->rows_count==0){$class_disabled = $this->btn_class_disabled;}
            } else { 
                $class_disabled = '';
                if($this->rows_count==0){$class_disabled = $this->btn_class_disabled;}
            }
            $li = $this->pagination_link($link_active, $class_disabled, $link_prev, $this->icon_before);
        }

        public function number_first_page(){
            if($this->page==1){$link_active = $this->btn_class_enabled;}else{$link_active = '';}
            $class_disabled = '';
            $li = $this->pagination_link($link_active, $class_disabled, 1, 1);
        }

        public function number_etc_page_begin(){
            $link_active = '';
            $class_disabled = '';
            $start_number_minus1 = $this->startNumber-1;
            if ($this->startNumber+1 >= $this->nBtns) { 
                $li = $this->pagination_link($link_active, $class_disabled, $start_number_minus1, $this->icon_etc);
            }
        }

        public function number_page(){
            $class_disabled = '';
            if($this->rows_count!=0 && $this->rows_count>$this->limit){
                for ($i = $this->startNumber; $i <= $this->endNumber; $i++) {
                    $link_active = ($this->page == $i) ? $this->btn_class_enabled : '';   
                    if ($i != '1' && $i != $this->nPages) {
                        $li = $this->pagination_link($link_active, $class_disabled, $i, $i);
                    }
                }
            }
        }

        public function number_etc_page_end(){
            $class_disabled = '';
            if($this->page==$this->nPages){$link_active = $this->btn_class_enabled;}
            $end_number_max1 = $this->endNumber+1;
            if ($end_number_max1 < $this->nPages) {
                $link_active = '';
                $li = $this->pagination_link($link_active, $class_disabled, $end_number_max1, $this->icon_etc);
            }
        }

        public function number_end_page(){
            if($this->rows_count!=0 && $this->rows_count>$this->limit){
                $class_disabled = '';
                if($this->page==$this->nPages){$link_active = $this->btn_class_enabled;}else{$link_active = '';}
                $li = $this->pagination_link($link_active, $class_disabled, $this->nPages, $this->nPages);
            }
        }

        public function number_page_next(){
            $link_next = ($this->page < $this->nPages) ? $this->page + 1 : $this->nPages;
            if ($this->page == $this->nPages) {
                $link_active = '';
                $class_disabled = $this->btn_class_disabled;  
                if($this->rows_count==0){$class_disabled = $this->btn_class_disabled;}
            } else {
                $link_active = '';
                $class_disabled = '';
                if($this->rows_count==0){$class_disabled = $this->btn_class_disabled;}
            }
            $li = $this->pagination_link($link_active, $class_disabled, $link_next, $this->icon_next);
        }
    }
?>