<?php
namespace frame;
class session{
    public function __construct(){
        session_start();
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
    public function add($name,$value,$time=null){

        if(isset($_SESSION[$name])){
            throw new \Exception("This variable for $name have exisited");
        }else{
            $_SESSION[$name]['value'] = $value;
            $nowtime = time();
            if($time==null){
                $_SESSION[$name]['last_time'] = $nowtime+3600;
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
        $_SESSION[$name]['last_time'] = time()+3600;
    }
    public function del($name){
        unset($_SESSION[$name]);
    }
    public function destory(){
        session_destroy();
    }
}
?>