<?php
   /**
    * 数据库配置
    */

   return array(
       "class"=>'spread\db\Db',
       "db_host" => 'localhost',          //数据库所在的地址；
       "db_name" => 'database',                  //数据库的名称
       "db_user" => 'yourusername' ,                  //数据库用户名
       "db_pass" => 'yourpassword',                   //数据库密码
       "db_charset" => 'utf8'             //编码类型，默认为utf8
   );

?>
