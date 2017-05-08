<?php
namespace spread\thinkcore;
class App{
    public static $config;
    public function __construct($config){
        self::$config = $config;
    }
	public function run(){
		    
		   $routinfo = self::$config['route'];
  
           $routeway = $routinfo['routeway'];
		   $routedefaultpath = $routinfo['routedefaultpath'];

           if($routeway == '/'){
               if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/') {
                   $pathRequst = $_SERVER['PATH_INFO'];
                   $pathstr = trim($pathRequst,'/');
               }else{
                   $pathstr = $routedefaultpath;
               }
              
           }elseif($routeway == 'r') {
               if (isset($_GET['r']) && isset($_GET['rounte'])) {
                   $pathstr = $_GET['r'];
               } else if (isset($_GET['r'])) {
                   $pathstr = $_GET['r'];
               } else if (isset($_GET['rounte'])) {
                   $pathstr = $_GET['rounte'];
               } else {
                   $pathstr = $routedefaultpath;
               }
           }else{
               throw new Exception('此种路由方式不存在：'.$routeway);
           }
			 $arr = explode('/',$pathstr);
			 $path = WEB_ROOT.'/controllers';
			 
			 if(count($arr)>=3){
				 foreach($arr as $key=>$val){
					 $path.='/'.ucfirst(strtolower($arr[0]));
					 if(count($arr)-intval($key)==2){
						 if(!file_exists($path)){
                             throw new Exception('没有发现该文件：'.$arr[1].'.php');
						 }
						 $controller = ucfirst(strtolower($arr[0]));
					 }elseif(count($arr)-intval($key)==1){
						 $action = strtolower($val).'Action';  
						
						 if(!is_dir($path)){
                             throw new Exception('没有发现该目录：'.$arr[0]);
						 }
					 }
				 }			 
			 }elseif(count($arr)==2){
				 $path =$path. '/'.ucfirst(strtolower($arr[0]));
				 if(!file_exists($path.'Controller.php')){
					 throw new Exception('没有发现该文件：'.$arr[0].'.php');
				 }
				 $controller = ucfirst(strtolower($arr[0]));
				 $action     = strtolower($arr[1]).'Action';
				
			 }else{
				
			 }
			$controller = $controller.'Controller';
			$class  = new \ReflectionClass('controllers\\'.$controller);
			$class->newInstance()->$action();
	}
    public function __get($name){
        if(isset(self::$config[$name])){
			
            $objectConfig = self::$config[$name];
            if (isset($objectConfig['class'])){
               $objectName = $objectConfig['class'];
            } else{
               $objectName = $name;
            }            
            $class  = new \ReflectionClass($objectName); // 建立 $object类的反射类 
            $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
            $public_properties = array();
            foreach ($properties as $t){
                if ($t->isPublic()){
                    $public_properties[] = $t->getName();
                }
            }
			$object = $class->newInstance(); 
            foreach ($objectConfig as $key=>$val){
				if ($class->hasMethod('__set') && $key != 'class'){
					$object->$key = $val;
				} else{
				   if (property_exists($objectConfig['class'], $key) && in_array($key, $public_properties)){
					  $object->$key = $val;
				   }
				}
            }
            return $object; 
        }else{
			throw new \Exception('not found class '.$name);
		}
    }
    public function __set($name,$value){
        $this->$name = $value;
    }
}