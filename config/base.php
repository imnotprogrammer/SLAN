<?php
    return array(
        'web_host' => 'localhost',
		'smartyEngine' => 'on',    //smarty模板引擎是否启动，on表示启动，off表示关闭，默认为on开启
        'extension' => array(
            'PHPMailer' => array(   //扩展名，即目录名
                'loadfile' => array('PHPMailerAutoload.php')//需要加载的文件
            ),
            'PHPExcel' => array(
                'loadfile' => array('PHPExcel/Shared/String.php','PHPExcel.php','PHPExcel/Writer/Excel2007.php')
            )
        ),	
    );

?>
