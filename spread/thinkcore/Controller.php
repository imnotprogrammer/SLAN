<?php
/**
 * 作者：清风送月
 * 时间：2016年8月23日16:55:52
 * 功能：主要定义MVC中C的基类,其子类继承该类时可以继承大量的优化方法。
 */
namespace spread\thinkcore;
     class Controller{
         /**
          * @var \Smarty
          * 定于smarty，利用smarty调用模板引擎
          */
         protected $smarty;
         public $smarty_status;
         /**
          *配置smarty的相关信息
          */
         public function __construct(){
			 $this->smarty = SLAN::$app->smarty;
			 $this->smarty->init();
 
         }

         /**
          * @param $view  需要展示的页面
          * @param array $arr 向页面传递的值
          */
         public function display($view,$arr=array()){
             if($view==null){
                 throw new \Exception('你没有选择模板文件');
             }
			 if($this->smarty_status===false){
				 if($arr){
					foreach($arr as $key => $val){
						$$key = $val;
					}					
				 }
				 include WEB_ROOT.'/views/'.$view;
			 }else{
				 if($arr) {
                     $this->smarty->assign('value',$arr);
                 }
				 $this->smarty->display($view); 
			 }   
         }

         /**
          * @param $data 如果该值为数组，$parm无论传何值，都不会理会；
          * @param null $parm
          */
         public function assign($name,$parm = null){
			 if($this->smarty_status===false){
				 throw new \Exception('smarty模板引擎未开启，请参考display申请变量');
			 }else{
				 $this->smarty->assign($name,$parm);
			 }            
         }
     }
?>