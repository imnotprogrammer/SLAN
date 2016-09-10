<?php
namespace frame;
class session{	
    public $lifetime=0;
    public function __construct(){
        
        $this->lifetime = ini_get('session.gc_maxlifetime');
    }

    /**
     * @param $value
     * 这个方法被用作是否启用cookie作为存储session id的值，
     * true 启用 false 不启用
     * null代表用另外的方式存储id的值
     */
    public function setUseCookies($value)
    {
        if ($value === false) {
            ini_set('session.use_cookies', '0');
            ini_set('session.use_only_cookies', '0');
        } elseif ($value === true) {
            ini_set('session.use_cookies', '1');
            ini_set('session.use_only_cookies', '1');
        } else {
            ini_set('session.use_cookies', '1');
            ini_set('session.use_only_cookies', '0');
        }
    }
    public function __get($name){
        if(isset($_SESSION[$name])){
            if(time()>$_SESSION[$name]['last_time']){
                $this->del($name);
                return null;
            }
            return $_SESSION[$name]['value'];
        }else{
            return null;
        }
    }
    public function setMaxLifeTime($time){
        ini_set('session.gc_maxlifetime',$time);
        $this->lifetime = ini_get("session.gc_maxlifetime");
    }
    public function add($name,$value,$time=null){

        if(isset($_SESSION[$name])){
            throw new \Exception("This variable for $name have exisited");
        }else{
            $_SESSION[$name]['value'] = $value;
            $nowtime = time();
            if($time==null){
                $_SESSION[$name]['last_time'] = $nowtime+$this->lifetime;
            }else{
                $_SESSION[$name]['last_time'] = $nowtime+$time;
            }
        }
    }
    public function update($name,$upvalue){
        if(isset($_SESSION[$name])){
            $_SESSION[$name]['value'] = $upvalue;
        }
    }
    public function __set($name,$value){
        $_SESSION[$name]['value'] = $value;
        $_SESSION[$name]['last_time'] = time()+$this->lifetime;
    }
    public function del($name){
        unset($_SESSION[$name]);
    }
    public function destory(){
        session_destroy();
    }
}
?>