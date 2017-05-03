<?php
/* Smarty version 3.1.30, created on 2016-11-20 11:00:29
  from "/var/www/newThink/views/login.php" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5831824d0f4df3_51945214',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f8cc55657f5d438a26f06def4be5c30c3e8709e' => 
    array (
      0 => '/var/www/newThink/views/login.php',
      1 => 1478971386,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5831824d0f4df3_51945214 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>版本发布管理系统</title>
    <link rel="stylesheet" href="res/css/login.css">
    <?php echo '<script'; ?>
 src="/res/js/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/res/js/ver.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/res/js/layer/layer.js"><?php echo '</script'; ?>
>
	<style>
		
	</style>
</head>
<body>
    <div class="loginBox">
        <div class="logoText">版本发布管理系统 | 登录</div>
        <div class="login_up">
            <form name="loginForm">
                <div><span>用户名：</span><input type="text" name="uname" placeholder="请输入用户名" class="info_t"/></div>
                <div><span>密码：</span><input type="password" name="upass" placeholder="请输入密码" class="info_t"/></div>
                <div>
                    <span>验证码：</span>
                    <input type="text" name="uvercode" placeholder="请输入验证码" class="verCode_t"/>
                    <img src="?r=vercode/index" class="verCode_last"  onclick="this.src='?r=vercode/index&'+Math.random()" />
                </div>
            </form>
            <div class="loginBtn" onclick="login()">登录</div>
        </div>
        
    </div>
    <footer>版本发布管理系统&copy;2015-2018</footer>
  
</body>
</html>
<?php }
}
