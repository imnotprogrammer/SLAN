<?php
use frame\Controller;
class TestController extends Controller{
    public function indexAction(){
        $this->assign('title',"dsfsdf");
        $this->display('index.php');
        $objPHPExcel = new PHPExcel();
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    }
}
?>