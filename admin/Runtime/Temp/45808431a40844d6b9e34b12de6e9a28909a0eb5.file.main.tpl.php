<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:48
         compiled from "../admin/Tpl/Index/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77213407558f6bdc8cec255-76683871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45808431a40844d6b9e34b12de6e9a28909a0eb5' => 
    array (
      0 => '../admin/Tpl/Index/main.tpl',
      1 => 1492483003,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77213407558f6bdc8cec255-76683871',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
    'key' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc8d3ce1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc8d3ce1')) {function content_58f6bdc8d3ce1($_smarty_tpl) {?><div class="main" >
<div class="content">
<TABLE id="checkList" class="list" cellpadding=0 cellspacing=0 >
<tr><td height="5" colspan="5" class="topTd" ></td></tr>
<TR class="row" ><th colspan="3" class="space">系统信息</th></tr>
<?php  $_smarty_tpl->tpl_vars["v"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["v"]->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["v"]->key => $_smarty_tpl->tpl_vars["v"]->value){
$_smarty_tpl->tpl_vars["v"]->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars["v"]->key;
?>
<TR class="row" ><TD width="15%"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</TD><TD><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</TD></TR>
<?php } ?>
<tr><td height="5" colspan="5" class="bottomTd"></td></tr>
</TABLE>
</div>
</div>
<?php }} ?>