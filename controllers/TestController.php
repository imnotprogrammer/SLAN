<?php
use spread\thinkcore\conf;
use spread\db\DBActive;
use spread\thinkcore\Controller;
use models\test;
class TestController extends Controller{
	
    public function indexAction(){
		$info = test::returnInfo();
		$this->assign('infomation',$info);
		$this->display('index.tpl');
    }
	
}
?>
