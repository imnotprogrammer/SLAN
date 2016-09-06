<?php
use frame\conf;
use frame\db\Db;
use frame\Controller;
class lanController extends Controller{
    public function indexAction()
    {
        $addr1 = 'youyilunmingyue@163.com';
        $addr3 = 'lanshiqingfeng@163.com';
        $addr2 = 'lanyuguo@foxmail.com';
        $addr4 = '18349299452@163.com';
        $addr5 = 'lan@netmoon.cn';
        $this->assign('title', '欢迎你使用蓝雨果框架');
        $this->display('index.php');

        $db = new \frame\db\DBActive();
        //$db->table('tb_user')->save(["test_name"=>"lanyuguo","test_pass"=>"1234567890"]);
        $db->table('tb_user')->where(array("test_name"=>"lan","test_id"=>24))->update(["test_pass"=>2222232]);

    }
}
?>