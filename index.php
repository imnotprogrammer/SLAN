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
    /* $config = [
		     'smarty' => array(
			    'class'=>'spread\smarty\libs\Basesmarty',
				'status' => true, //smarty模板引擎是否启动，true表示启动，false表示关闭，默认为on开启			
				'template_dir' => WEB_ROOT.'/views',
				'compile_dir' => WEB_ROOT.'/spread/smarty/template_c',
				'plugins_dir' => WEB_ROOT.'/spread/smarty/plugins',
				'cache_dir' => WEB_ROOT.'/spread/smarty/cache',
				'config_dir' => WEB_ROOT.'/spread/smarty/config',
				'caching' => false,
				'cache_lifetime'=> 60*60*24,
				'left_delimiter'=>'{',
				'right_delimiter'=>'}'
		    ),
            'route'=>[
			    'routeway' => 'r',
				'routedefaultpath'=>'test/index'
			]			
        ]; */
	$config = require_once(WEB_ROOT.'/config/base.php');
	require(WEB_ROOT.'/spread/thinkcore/Auto_load.php');
	(new spread\thinkcore\Application($config))->run();













