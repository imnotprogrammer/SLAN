<?php
    return array(
        'web_host' => 'localhost',
        'timezone' => 'GMT',
		//'ifsessionshare' =>array(''),
		'smarty' => array(
		    'status' => true , //smarty模板引擎是否启动，true表示启动，false表示关闭，默认为on开启
			'setconf' =>array(
			    'templatedir' => WEB_ROOT.'/views',
			    'compiledir' => WEB_ROOT.'/spread/smarty/template_c',
				'pluginsdir' => WEB_ROOT.'/spread/smarty/plugins',
				'cachedir' => WEB_ROOT.'/spread/smarty/cache',
				'configdir' => WEB_ROOT.'/spread/smarty/config',
				'caching' => false,
				'cache_lifetime'=> 60*60*24,
				'left_delimiter'=>'{',
				'right_delimiter'=>'}'
			)
		),   
        'extension' => array(),	
    );

?>
