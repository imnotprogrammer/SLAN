<?php
namespace controllers;
use spread\thinkcore\SLAN;
use spread\thinkcore\conf;
use spread\db\DBActive;
use spread\thinkcore\Controller;
use models\test;
class TestController extends Controller{
	
    public function indexAction(){
		$info = test::returnInfo();
		$db = SLAN::$app->db->init()->add('t5',['id'=>3,'dt'=>2]);
		var_dump($db);
		$this->assign('infomation',$info);
		$this->display('index.tpl');
		
    }
	
}
?>
