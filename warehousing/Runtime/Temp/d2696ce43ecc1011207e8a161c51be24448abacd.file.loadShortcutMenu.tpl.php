<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:46
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Ajax/loadShortcutMenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:94290244158f6bdc6609a26-78413268%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2696ce43ecc1011207e8a161c51be24448abacd' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Ajax/loadShortcutMenu.tpl',
      1 => 1492482586,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '94290244158f6bdc6609a26-78413268',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'short_menu' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc66a954',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc66a954')) {function content_58f6bdc66a954($_smarty_tpl) {?><div class="top_right_arrow">  
<img src="__PUBLIC__/Images/Default/arrow_down.png" id="sdfjasdlfasdf">
</div>
<div class="top_right">
<ul class="fast">
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['short_menu']->value['short']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li><a onclick="javascript:addTab('<?php echo U(($_smarty_tpl->tpl_vars['item']->value['model'])."/".($_smarty_tpl->tpl_vars['item']->value['action']));?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['menu_name'];?>
');$('#shortMenuHide').hide();">
	<div class="box1"><div class="cc"><span class="arrow_icontop">&nbsp;</span><span><?php echo $_smarty_tpl->tpl_vars['item']->value['menu_name'];?>
</span></div></div>
</a></li>
<?php } ?>
</ul>
</div>

<div id="shortMenuHide" class="none">
<ul class="shortcutmenu">
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['short_menu']->value['hidden']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li><a onclick="javascript:addTab('<?php echo U(($_smarty_tpl->tpl_vars['item']->value['model'])."/".($_smarty_tpl->tpl_vars['item']->value['action']));?>
','<?php echo $_smarty_tpl->tpl_vars['item']->value['menu_name'];?>
');$('#shortMenuHide').hide();">
	<span class="arrow_icontop">&nbsp;</span><span><?php echo $_smarty_tpl->tpl_vars['item']->value['menu_name'];?>
</span>
</a></li>
<?php } ?>
</ul>
</div><?php }} ?>