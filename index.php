<?php
/**
 * 作者：清风送月;
 * 功能：这个页面主要用于框架的入口文件；完成路由，自动加载，初始化等功能；
 * 时间：2016年8月23日16:19:58
 * 邮箱：lanshiqingfeng@163.com
 */
use spread\thinkcore\conf;
defined('DEBUG') or define('DEBUG', true);
defined('WEB_ROOT') or define('WEB_ROOT', __DIR__);	
$config = require_once(WEB_ROOT.'/config/base.php');
require(WEB_ROOT.'/spread/thinkcore/Auto_load.php');

(new spread\thinkcore\Application($config))->run();













