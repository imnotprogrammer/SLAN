<?php
namespace frame;
    class Email extends \PHPMailer{
        private $conf;
        public $touser;
        public $tousername;
        public function __construct($touser,$tousername)
        {
            $this->conf = conf::getConf('email');

            $this->isSMTP();// 使用SMTP服务
            $this->CharSet = $this->conf['Charset'];// 编码格式为utf8，不设置编码的话，中文会出现乱码
            $this->Host = $this->conf['EmailServer'];// 发送方的SMTP服务器地址
            $this->SMTPAuth = true;// 是否使用身份验证
            $this->Username = $this->conf['FromUserAddr'];// 发送方的163邮箱用户名
            $this->Password = $this->conf['Password'];// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！
            $this->SMTPSecure = $this->conf['SMTPSecure'];// 使用ssl协议方式
            $this->Port = $this->conf['Port'];// 163邮箱的ssl协议方式端口号是465/994
            $this->touser = $touser;
            $this->tousername = $tousername;
            $this->setFrom($this->conf['FromUserAddr'], $this->conf['FromUserName']);// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为thiser(xxxx@163.com），thiser是当做名字显示
            $this->addAddress($this->touser, $this->tousername);// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
            //$this->addReplyTo("lan@netmoon.com","Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
            //$this->addCC("aaaa@inspur.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址
            //$this->addBCC("bbbb@163.com");// 设置秘密抄送人
            //$this->addAttachment("bug0.jpg");// 添加附件
            // $this->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
           parent::__construct();
        }
        public function setToUser($touser,$tousername){
            $this->touser =$touser;
            $this->tousername = $tousername;

        }
        public function send($title=null,$text=null){
            if($title==null){
                $this->Subject = '邮件标题';
            }else{
                $this->Subject = $title;
            }
            if($text==null){
                $this->Body = '邮件内容';
            }else{
                $this->Body = $text;
            }
            if(parent::send()){
                return  'Email have been sent!';
            }else{
                return  'Email find error:'.$this->ErrorInfo;
            }
        }
    }
?>