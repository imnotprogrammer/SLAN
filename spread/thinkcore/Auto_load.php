<?php
namespace spread\thinkcore;
class Auto_load{
/*
	 * 自动加载调用方法
	 * 其中register为入口
	 */
	public static function Register(){
		spl_autoload_register(array("\\spread\\thinkcore\\Auto_load","Auto_load"));
	}

	/**
	 * @param $class
	 * @return bool
	 * 自动加载函数根据加载的类来加载相应的文件
	 */
	public static function Auto_load($class){
		if ((class_exists($class,FALSE))) {
			return false;
		}
		$file = WEB_ROOT.'/'.str_replace('\\','/',$class).'.php';		
		if(file_exists($file)){
			//echo $file;
			include $file;			
		}else{			
			return false;
		}
		return true;
	}
}
Auto_load::Register();