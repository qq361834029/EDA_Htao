<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:48
         compiled from "../admin/Tpl/Index/top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:45941159958f6bdc8be4c79-86572374%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd738fb8ecc42f73a86a0c963088b8208a8537173' => 
    array (
      0 => '../admin/Tpl/Index/top.tpl',
      1 => 1492483003,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45941159958f6bdc8be4c79-86572374',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nodeGroupList' => 0,
    'key' => 0,
    'tag' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc8c4ff8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc8c4ff8')) {function content_58f6bdc8c4ff8($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.counter.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『友拓通－管理平台』</title>
<link rel='stylesheet' type='text/css' href='__PUBLIC__/Css/admin.css'>
<base target="main" />
<style type="text/css">
body{ width:100%;}
</style>
</head>
<body>
<!-- 头部区域 -->
<div id="header" class="header">
<div class="headTitle" style="margin:8pt 10pt"> 管理平台 </div>
	<!-- 功能导航区 -->
	<div class="topmenu">
<ul>
<li><span><a href="#" onClick="sethighlight(0); parent.menu.location='__URL__/menu/title/后台首页';parent.main.location='__URL__/main/';return false;">后台首页</a></span></li>
<?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['nodeGroupList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value){
$_smarty_tpl->tpl_vars['tag']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tag']->key;
?>
<li><span><a href="#" onClick="sethighlight(<?php echo smarty_function_counter(array(),$_smarty_tpl);?>
); parent.menu.location='__URL__/menu/tag/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
/title/<?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
';return false;"><?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
</a></span></li>
<?php } ?>
<li><span><a href="#" onClick="parent.main.location='__APP__/Other/updateCache/';return false;" >更新全部缓存</a></span></li>
</ul>
</div>
	<div class="nav">
	<a href="__APP__/Public/logout" target="_top"><img SRC="__PUBLIC__/Images/Admin/error.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="" align="absmiddle"> 退 出</a></div>
</div>
<script>
function sethighlight(n) {
	var lis = document.getElementsByTagName('span');
	for(var i = 0; i < lis.length; i++) {
		lis[i].className = '';
	}
	lis[n].className = 'current';
}
sethighlight(0);
</script>
</body>
</html><?php }} ?>