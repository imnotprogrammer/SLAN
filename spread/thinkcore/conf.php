<?php
namespace spread\thinkcore;

    class conf{
        public static $conf = array();

        /**
         * @param string $conf
         * @return array|mixed
         */
        public static function getConf($conf =''){

            $path = WEB_ROOT . '/config/' . $conf . '.php';

            if (file_exists($path)) {
                self::$conf = include($path);
                return self::$conf;
            } else {
                throw new \Exception('没有发现配置文件：' . $conf . '.php');
            }
        }

        /**
         * @param string $conf
         * @param $confindex
         * @return mixed
         */
        public static function getOne($conf,$confindex =''){
            $path = WEB_ROOT . '/config/' . $conf . '.php';
            if (file_exists($path)) {
                $confs = include($path);				//print_r($confs);echo $confs[$confindex];
                return $confs[$confindex];
            } else {
                throw new \Exception('没有发现配置文件：' . $conf . '.php');
            }
        }
    }
?>