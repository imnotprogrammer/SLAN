<?php
/**
 * 作者：清风送月
 * 时间：2016年8月23日16:55:52
 * 功能：主要定义MVC中C的基类,其子类继承该类时可以继承大量的优化方法。
 */
namespace frame;

     class Controller{
         /**
          * @var \Smarty
          * 定于smarty，利用smarty调用模板引擎
          */
         protected $smarty;

         /**
          *配置smarty的相关信息
          */
         public function __construct(){
             require_once(WEB_ROOT."/frame/smarty/libs/Smarty.class.php");
			$this->smarty = new \smarty();
			$this->smarty->setTemplateDir(WEB_ROOT.'/views')
							  ->setCompileDir(WEB_ROOT.'/frame/smarty/template_c')
							  ->setPluginsDir(WEB_ROOT.'/frame/smarty/plugins')
							  ->setCacheDir(WEB_ROOT.'/frame/smarty/cache')
							  ->setConfigDir(WEB_ROOT.'/frame/smarty/config');
			$this->smarty->caching = false;
			$this->smarty->cache_lifetime = 60*60*24;
			$this->smarty->left_delimiter = '{';
			$this->smarty->right_delimiter = '}';	
					 
         }

         /**
          * @param $view  需要展示的页面
          * @param array $arr 向页面传递的值
          */
         public function display($view,$arr=array()){
             if($view==null){
                 throw new \Exception('你没有选择模板文件');
             }
             $this->smarty->display($view);
             if($arr) {
                 $this->smarty->assign('value',$arr);
             }
         }

         /**
          * @param $data 如果该值为数组，$parm无论传何值，都不会理会；
          * @param null $parm
          */
         public function assign($data,$parm = null){
             if(is_array($data) && $parm == null){
                 foreach($data as $key=>$val){
                     $this->smarty->assign($key,$val);
                 }
             }elseif(is_array($data) && $parm != null){
                 $parm = null;
             }else{
                 $this->smarty->assign($data, $parm);
             }
         }
     }
?>