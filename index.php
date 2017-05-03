<?php
/**
 * 作者：清风送月;
 * 功能：这个页面主要用于框架的入口文件；完成路由，自动加载，初始化等功能；
 * 时间：2016年8月23日16:19:58
 */
    defined("WEB_ROOT") or define("WEB_ROOT",__DIR__);
    defined("ECHO_EOL") or define("ECHO_EOL",'<br>');
    define('DEBUG',true);

    require(WEB_ROOT.'/frame/Lan.php'); //自动加载和初始化
    require(WEB_ROOT.'/common/common.php');
    \frame\app::run();
      echo phpinfo();
?>
