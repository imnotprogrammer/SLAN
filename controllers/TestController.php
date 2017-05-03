<?php
use spread\thinkcore\conf;
use spread\db\DBActive;
use spread\thinkcore\Controller;

class TestController extends Controller{
	
    public function indexAction(){
		//session_start();
		$route = conf::getConf('item');		
		$routepath = array_keys($route,'一键除草',true);
		$routepath = $routepath[0];
		echo $routepath;
        //phpCAS::client(CAS_VERSION_2_0,"192.168.169.128",80,"/?r=test/index");  
    }
	public function loginCas(){  
        Header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');  
        //引人cas  
        //include 'CAS-1.2.0/CAS.php';  
        // initialize phpCAS   
        //phpCAS::client(CAS_VERSION_2_0,'服务地址',端口号,'cas的访问地址');  
        phpCAS::client(CAS_VERSION_2_0,"192.168.169.128",80,"/?r=test/index",true);  
  
        //可以不用，用于调试，可以通过服务端的cas.log看到验证过程。  
        // phpCAS::setDebug();  
        //登陆成功后跳转的地址 -- 登陆方法中加此句  
        phpCAS::setServerLoginUrl("https://192.168.142.1:80/cas/login?embed=true&cssUrl=http://localhost/phpCasClient/style/login.css&service=http://localhost/phpCasClient/user.php?a=loginCas");  
        //no SSL validation for the CAS server 不使用SSL服务校验  
        phpCAS::setNoCasServerValidation();  
        //这里会检测服务器端的退出的通知，就能实现php和其他语言平台间同步登出了  
        phpCAS::handleLogoutRequests();  
          
        if(phpCAS::checkAuthentication()){  
            //获取登陆的用户名  
            $username=phpCAS::getUser();  
            //用户登陆成功后,采用js进行页面跳转  
            echo "<script language=\"javascript\">parent.location.href='http://localhost/phpCasClient/home.php';</script>";  
        }else{  
            // 访问CAS的验证  
            phpCAS::forceAuthentication();  
        }  
        exit;  
    }  
}
?>
