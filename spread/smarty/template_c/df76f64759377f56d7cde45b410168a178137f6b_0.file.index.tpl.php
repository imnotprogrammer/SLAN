<?php
/* Smarty version 3.1.30, created on 2017-05-06 03:07:22
  from "F:\git_project_dir\SLAN\views\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_590d3dea35e804_66771694',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'df76f64759377f56d7cde45b410168a178137f6b' => 
    array (
      0 => 'F:\\git_project_dir\\SLAN\\views\\index.tpl',
      1 => 1494035681,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_590d3dea35e804_66771694 (Smarty_Internal_Template $_smarty_tpl) {
?>
<html>
<body>
<style>

    #slan{
	width:150px;
	height:150px;
	margin:40px auto;
	}
    #circle_bot{  
    background-color:green;  
    width: 150px;  
    height: 150px;  
    margin: 0px 0 0 0px;  
    border-radius: 50%;  
    }  
    #circle_mid {  
    background-color:yellow;  
    width: 100px;  
    height: 100px;  
    margin: -125px 0 0 25px;  
    border-radius: 50%;  
	text-align:center;
	line-height:100px;

    }  
  #info_display{
      margin:20px auto;
	  height:20px;
	  text-align:center;
	  letter-spacing:4px;
	  font-weight:bold;
	  font-size:18px;
  }

</style> 
<div id="slan"> 
    <div id="circle_bot"></div>  
    <div id="circle_mid">  
	   <strong>SLAN 2.0</strong><br>
    </div>  
</div>
<div id="info_display"><?php echo $_smarty_tpl->tpl_vars['infomation']->value;?>
</div>
</body>
</html><?php }
}
