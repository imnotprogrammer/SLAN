<?php
namespace frame;

class Lan{

    protected static $arrmap = array();
    
	public function __construct(){
		self::init();
	}
    /**
     * @param $class
     * @return bool
     */
	public static function init(){
		$confs = conf::getConf('base');
        //var_dump($confs['extension']);
        $includefile = array();
        foreach ((array)$confs['extension'] as $key => $val) {
		    $dirpath = WEB_ROOT . '/frame/' . $key;
		    foreach ((array)$val['loadfile'] as $loadfile){
				$includefile[] = $dirpath . '/' . $loadfile;				
			}
				$dirpath = null;
        }         
	    foreach($includefile as $file){
			require_once $file;
		}
	}
	/*
	 * 自动加载调用方法
	 * 其中register为入口
	 */
	public static function register(){
		spl_autoload_register(array("\\frame\\Lan","auto_load"));
	}

	/**
	 * @param $class
	 * @return bool
	 * 自动加载函数根据加载的类来加载相应的文件
	 */
	public static function auto_load($class){
		if ((class_exists($class,FALSE))) {
			return false;
		}
		$file = WEB_ROOT.'/'.str_replace('\\','/',$class).'.php';
		if(file_exists($file)){
			require_once $file;
		}else{
			return false;
		}
		return true;
	}
}
	Lan::register();
	Lan::init();
?>
