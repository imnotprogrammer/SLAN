<?php
namespace spread\thinkcore;
use spread\thinkcore\App;
class Application{
    public $config;
	public $version = '2.0';
    public function __construct($config) {
        $this->config = $config;
    }
    public function run(){
         SLAN::$app =  new App($this->config);
		 SLAN::$app->run();
         //return $app;
    }
   
}