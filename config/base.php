<?php
    $route = require_once('route.php');
	$email = require_once('email.php');
	$db = require_once('db.php');
    return array(
        'web_host' => 'localhost',
        'timezone' => 'GMT',
		//'ifsessionshare' =>array(''),
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
        'route'=>$route,
        'email'=>$email,
        'db'=>$db,		
        'extension' => [

		],	
    );

?>
