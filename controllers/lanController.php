<?php
use frame\conf;
use frame\db\Db;
use frame\Controller;
/**
 * 测试实例
 */
class lanController extends Controller{
    public function indexAction(){
        $this->assign('title', '欢迎你使用SLan框架');
        $this->display('index.php');
    }
}
?>
