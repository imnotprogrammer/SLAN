<?php
/**
 * 作者：清风送月
 * 时间：2016年8月26日15:09:52
 * 简介：此类的主要用于分页。其中包含三种自带的分页方式，满足用户的不同需求
 */

namespace frame;

    class Page{
        /**
         * @var 共可以分多少页
         */
        public $pagecount;
        /**
         * @var 一页显示多少条数据;
         */
        public $pagesize;
        /**
         * @var int 当前页码
         */
        public $page = 1;
        /**
         * @var 总共有多条数据
         */
        public $sum;
        /**
         * @var 分页的风格类型
         */
        public $styletype;
        /**
         * @var null 最后返回的页码字符串;
         */
        public $html = null;
        /**
         * @var null
         */
        public $style = null;
        /**
         * @var int 最大页码，默认为1
         */
        public $maxpage = 1;
        /**
         * @var int 最小页码
         */
        public $minpage = 1;

        const   STYLE_TYPE_RECT = 1;
        const   STYLE_TYPE_DIALOG = 2;
        const   STYLE_TYPE_CIRCLE = 3;

        public function __construct($num,$pagesize,$page=1){
            $this->sum = $num;
            $this->pagesize = $pagesize;
            $this->page = $page;
            echo $this->page;
        }

        /**
         * @return float|共可以分多少页|int
         * 计算可以分多少页
         */
        public function getPageCount(){
            $temp = $this->sum % $this->pagesize;
            if($temp == 0){
                $this->pagecount = $this->sum/$this->pagesize;
            }else{
                $this->pagecount = intval($this->sum/$this->pagesize) + 1;
            }
            $this->maxpage = $this->pagecount;

            return $this->pagecount;

        }

        /**
         * @return int
         * 超出页码范围的处理
         */
        public function pageDeal(){

            if($this->page > $this->maxpage){
                $this->page = $this->maxpage;
            }
            if($this->page < $this->minpage){
                $this->page = $this->minpage;
            }
            return $this->page;
        }

        /**
         * @return null|string
         * 返回的最终字符串
         */
        public function getPage(){
           if($this->pagecount == 0){
               return null;
           }else {
               $this->html .= '<div class="page">';
               if ($this->page == 1) {
                   $this->html .= '<a javascript:void(0)>上一页</a>';
               } else {
                   $this->html .= '<a href ="' . $_SERVER['PHP_SELF'] . '?page = ' . ($this->page - 1) . '">上一页</a>';
               }
               for ($i = 0; $i < $this->pagecount; $i++) {
                   $temp = $i + 1;
                   if ($this->page == $temp) {
                       $this->html .= '<a class="checked" href = "' . $_SERVER['PHP_SELF'] . '?page=' . ($i + 1) . '" >' . ($i + 1) . '</a>';
                   } else {
                       $this->html .= '<a  href = "' . $_SERVER['PHP_SELF'] . '?page=' . ($i + 1) . '" >' . ($i + 1) . '</a>';
                   }
               }
               $this->html .= '<span>共' . $this->pagecount . '页</span>';
               if ($this->page == $this->pagecount) {
                   $this->html .= '<a avascript:void(0)>下一页</a>';
               } else {
                   $this->html .= '<a href ="' . $_SERVER['PHP_SELF'] . '?page=' . ($this->page + 1) . '">下一页</a>';
               }
               $this->html .= '</div>';
               return $this->html;
           }
        }

        /**
         * @return null|string
         * 逻辑组合执行
         */
        public function spage(){
            if($this->getPageCount()){
                if($this->pageDeal()){
                    return $this->getPage();
                }
            }
        }
        public function dealStyle(){

        }
    }

?>