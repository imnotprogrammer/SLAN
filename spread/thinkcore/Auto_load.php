<?php
namespace spread\thinkcore;
class Auto_load{
/*
	 * �Զ����ص��÷���
	 * ����registerΪ���
	 */
	public static function Register(){
		spl_autoload_register(array("\\spread\\thinkcore\\Auto_load","Auto_load"));
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
			//echo $file;
			include $file;			
		}else{			
			return false;
		}
		return true;
	}
}
Auto_load::Register();