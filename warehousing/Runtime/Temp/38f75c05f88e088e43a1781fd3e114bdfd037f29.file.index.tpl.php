<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:45
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:169631865758f6bdc53023d1-97958584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38f75c05f88e088e43a1781fd3e114bdfd037f29' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Index/index.tpl',
      1 => 1492482589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169631865758f6bdc53023d1-97958584',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'menu1' => 0,
    'lang' => 0,
    'menu2' => 0,
    'menu3' => 0,
    'login_user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc54608e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc54608e')) {function content_58f6bdc54608e($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("Public/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="fiexd_header">
	<div class="menu">
	<?php  $_smarty_tpl->tpl_vars['menu1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu1']->key => $_smarty_tpl->tpl_vars['menu1']->value){
$_smarty_tpl->tpl_vars['menu1']->_loop = true;
?>
	<ul>
		<li class="white" <?php if (@LANG_SET=='de'){?>style='font-size: 12px;'<?php }?>><a href="javascript:;" class="white"><span style="color:#ffffff;"><?php echo $_smarty_tpl->tpl_vars['lang']->value["node_".($_smarty_tpl->tpl_vars['menu1']->value['id'])];?>
</span></a>
			<ul>
			<?php  $_smarty_tpl->tpl_vars['menu2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu1']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu2']->key => $_smarty_tpl->tpl_vars['menu2']->value){
$_smarty_tpl->tpl_vars['menu2']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['menu2']->value['sub']){?>
					<li><span class="span_w134"><a href="javascript:;" url="<?php echo U($_smarty_tpl->tpl_vars['menu2']->value['href']);?>
" title="<?php echo title($_smarty_tpl->tpl_vars['menu2']->value['id']);?>
" class="white"><?php echo title($_smarty_tpl->tpl_vars['menu2']->value['id']);?>
</a></span><span class="second_arrow fr"><a href="javascript:;">&nbsp;</a></span>
						<ul>
						<?php  $_smarty_tpl->tpl_vars['menu3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu3']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu2']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu3']->key => $_smarty_tpl->tpl_vars['menu3']->value){
$_smarty_tpl->tpl_vars['menu3']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['menu3']->value['ico_link']){?>
						<li><span class="span_w134"><a href="javascript:;" url="<?php echo U($_smarty_tpl->tpl_vars['menu3']->value['href']);?>
" title="<?php echo title($_smarty_tpl->tpl_vars['menu3']->value['id']);?>
" class="white"><?php echo title($_smarty_tpl->tpl_vars['menu3']->value['id']);?>
</a></span>
						<span class="menu_add fr"><a href="javascript:;" url="<?php echo U(($_smarty_tpl->tpl_vars['menu3']->value['module']).('/add'));?>
" title="<?php echo title($_smarty_tpl->tpl_vars['menu3']->value['ico_link']['id']);?>
">&nbsp;</a></span>
						</li>
						<?php }else{ ?>
						<li><a href="javascript:;" url="<?php echo U($_smarty_tpl->tpl_vars['menu3']->value['href']);?>
" title="<?php echo title($_smarty_tpl->tpl_vars['menu3']->value['id']);?>
"><?php echo title($_smarty_tpl->tpl_vars['menu3']->value['id']);?>
</a></li>
						<?php }?>
						<?php } ?>
						</ul>
					</li>
				<?php }else{ ?>
					<li><a href="javascript:;" url="<?php echo U($_smarty_tpl->tpl_vars['menu2']->value['href']);?>
" title="<?php echo title($_smarty_tpl->tpl_vars['menu2']->value['id']);?>
"><?php echo title($_smarty_tpl->tpl_vars['menu2']->value['id']);?>
</a></li>
				<?php }?>
			<?php } ?>
			</ul>
		</li>
	</ul>
	<?php } ?>
	</div>
	<div id="shortcutMenu" class="shortcutMenu"></div>
</div>
<div id="tabs">
	<ul><li><a href="#ui_tabs-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['sys_index'];?>
</a></li></ul>
	<div id="ui_tabs-1" style="width:100%;float:left;overflow-y:hidden;">
		<div style="height:750px;background:url('__PUBLIC__/Images/Default/index_bg.gif')" class="index_bg">
			<p class="t_center" style="padding-top:80px;"><img src="__PUBLIC__/Images/Default/index_tu.jpg"></p>
		</div>
	</div>
</div>
<div class="fiexd_footer"><?php echo $_smarty_tpl->getSubTemplate ("Index/toolbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="__PUBLIC__/Js/lodopFuncs.js"></script>
<script type="text/javascript">
	//登陆提醒
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']==C('SELLER_ROLE_TYPE')&&$_smarty_tpl->tpl_vars['login_user']->value['vat_quota_warning']){?>
	var warning	= "<?php echo $_smarty_tpl->tpl_vars['login_user']->value['vat_quota_warning'];?>
";
	$("<div> "+warning+"</div>").dialog({
		modal: true,
		resizable: false,
		buttons: {
			Ok: function() {
				$(this).remove();
			}
		}
	});
	$.ajax({
		type: "POST",
		url: APP + "/Ajax/setVatWarning",
		dataType: "text",
		cache: false
	});
	<?php }?>
</script><?php }} ?>