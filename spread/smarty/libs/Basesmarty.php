<?php
namespace spread\smarty\libs;
require_once ('Smarty.class.php');
class Basesmarty extends \Smarty {
	    public $status;
        function __construct() {
			parent::__construct();
			
                
        }
        function init() {
			if (!$this->status){
				throw new \Exception('smarty 模板引擎已经关闭');
			}
        }
}