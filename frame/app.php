<?php
namespace frame;
use Exception;
   class app{
        public static $exten;
       /**
        * app constructor.
        */
       public function __construct(){
	       require_once(WEB_ROOT.'/frame/smarty/libs/Smarty.class.php');
           require_once(WEB_ROOT.'/common/common.php');

       }

       /**
        * @throws Exception
        * 路由方法
        */
       public static function run(){

           if(true == DEBUG){
               ini_set('display_error','on');
           }else{
               ini_set('display_error','off');
           }
           $conf = conf::getConf('route');
           $routeway = $conf['defaultroute'];

           if($routeway == '/'){
               if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/') {
                   $pathRequst = $_SERVER['PATH_INFO'];
                   $pathstr = trim($pathRequst,'/');
               }else{
                   $pathstr = $conf['defaultController'] . '/' . $conf['defaultAction'];
               }

           }elseif($routeway == 'r') {
               if (isset($_GET['r']) && isset($_GET['rounte'])) {
                   $pathstr = $_GET['r'];
               } else if (isset($_GET['r'])) {
                   $pathstr = $_GET['r'];
               } else if (isset($_GET['rounte'])) {
                   $pathstr = $_GET['rounte'];
               } else {
                   $pathstr = $conf['defaultController'] . '/' . $conf['defaultAction'];
               }
           }else{
               throw new Exception('此种路由方式不存在：'.$routeway);
           }
			 $arr = array();
			 $arr = explode('/',$pathstr);
			 $path = WEB_ROOT.'/controllers';
			 
			 if(count($arr)>=3){
				 foreach($arr as $key=>$val){
					 $path.='/'.$val;
					 if(count($arr)-intval($key)==2){
						 if(!file_exists($path)){
                             throw new Exception('没有发现该文件：'.$arr[1].'.php');
						 }
						 $controller = $val;
						
					 }elseif(count($arr)-intval($key)==1){
						 $action = $val.'Action';  
						
						 if(!is_dir($path)){
                             throw new Exception('没有发现该目录：'.$arr[0]);

						 }
					 }
				 }			 
			 }elseif(count($arr)==2){
				 $path =$path. '/'.$arr[0];

				 if(!file_exists($path.'Controller.php')){
					 throw new Exception('没有发现该文件：'.$arr[0].'.php');
				 }
				
				 $controller = $arr[0];
				 $action     = $arr[1].'Action';
				
			 }else{
				
			 }
			require_once($path.'Controller.php');
			$controller = $controller.'Controller';	
			$con = new $controller;
			$con->$action();
	   }

       /**
        * @return mixed
        *
        */
	   public static function gethost(){
	       return conf::getOne('base','web_host');
       }

       /**
        * @return mixed
        */
       public static function getclientip(){
           return $_SERVER['REMOTE_ADDR'] ;
       }
       public static function exten(){
           self::$exten = new app();
           return self::$exten;
       }
       /**
        * @return mixed
        */
       public static function getserverip(){
           return $_SERVER['SERVER_ADDR'];
       }
       public function __get($name)
       {
           // TODO: Implement __get() method.
           self::$exten=$this;
           $class = 'frame\\'.$name;
           return new $class;
       }
   }
?>