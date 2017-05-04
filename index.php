<?php
/**
 * 作者：清风送月;
 * 功能：这个页面主要用于框架的入口文件；完成路由，自动加载，初始化等功能；
 * 时间：2016年8月23日16:19:58
 * 邮箱：lanshiqingfeng@163.com
 *
 */
    use spread\thinkcore\conf;
    //ini_set('display_error','on');
    ini_set('date.timezone','Etc/GMT-8');
    //date_default_timezone_set('Etc/GMT-8');
	//session_start();
    defined("WEB_ROOT") or define("WEB_ROOT",__DIR__);   
    define('DEBUG',true);    
    require(WEB_ROOT.'/spread/thinkcore/NewThink.php'); //自动加载和初始化
    require(WEB_ROOT.'/common/common.php');
    require(WEB_ROOT.'/config/define.php');
	spread\thinkcore\app::run(); 
?>












