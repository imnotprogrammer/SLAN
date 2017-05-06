<?php
namespace spread\thinkcore;

class NewThink{

   /*  protected static $arrmap = array();
    
	public function __construct(){
		self::init();
	} */
    /**
     * @param $class
     * @return bool
     */
	public static function init(){
		
		$confs = conf::getConf('base');
		date_default_timezone_set($confs['timezone']);
        $includefile = array();
        foreach ((array)$confs['extension'] as $key => $val) {
			$path = '/spread/' . $key;
			$dirpath = isset($val['class'])?str_replace('\\','/', $val['class']):$path;
		    //$dirpath = WEB_ROOT . '/spread/' . $key;
		   /*  foreach ((array)$val['loadfile'] as $loadfile){
				$includefile[] = $dirpath . '/' . $loadfile;				
			} */
			$includefile[] = WEB_ROOT .'/'. $dirpath . '.php';
			$dirpath = null;
        }   
	    foreach($includefile as $file){
			include $file;
		}
		
	}
	/*
	 * �Զ����ص��÷���
	 * ����registerΪ���
	 */
	public static function Register(){
		spl_autoload_register(array("\\spread\\thinkcore\\NewThink","Auto_load"));
	}

	/**
	 * @param $class
	 * @return bool
	 * �Զ����غ������ݼ��ص�����������Ӧ���ļ�
	 */
	public static function Auto_load($class){
		if ((class_exists($class,FALSE))) {
			return false;
		}
		$file = WEB_ROOT.'/'.str_replace('\\','/',$class).'.php';		
		if(file_exists($file)){
			include $file;			
		}else{			
			return false;
		}
		return true;
	}
} 
try{
	NewThink::Register();
	NewThink::init();	
}catch(\Execption $e){
	echo $e->getMessage();
}
?>
