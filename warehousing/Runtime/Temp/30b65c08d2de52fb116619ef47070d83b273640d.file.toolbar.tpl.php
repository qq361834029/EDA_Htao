<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:45
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Index/toolbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:183296582058f6bdc58c6d27-07310513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30b65c08d2de52fb116619ef47070d83b273640d' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Index/toolbar.tpl',
      1 => 1492482589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183296582058f6bdc58c6d27-07310513',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'login_user' => 0,
    'l_key' => 0,
    'l_item' => 0,
    'super_admin' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc59eb68',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc59eb68')) {function content_58f6bdc59eb68($_smarty_tpl) {?><div id="footpanel"><ul id="mainpanel">
<li>
<div class="bottom_blue fr"><div class="bottomcontent">
	<div id="shToolbar" class="fl arrow_icon arrow_right"></div>
	<div class="user"><?php echo $_smarty_tpl->tpl_vars['lang']->value['curr_user_name'];?>
：<?php echo $_smarty_tpl->tpl_vars['login_user']->value['user_name'];?>
</div>
	<?php if (C('remind_today_stat')==1){?>
	<div class="today"><a href="javascript:;" id="toolbar_stat" url="<?php echo U('Ajax/todayRemind');?>
"><img src="__PUBLIC__/Images/Default/icon_tj.png" /></a></div>
	<?php }?>
	<div class="menu_nav">
	<ul>
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['user_type']==2){?>
		<li><a href="javascript:;" id="toolbar_stat" url="<?php echo U('Ajax/statSellerBalance');?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['select_balance'];?>
</a></li>
	<?php }?>
	<li id="toolbar_remind"><a href="javascript:;" url="<?php echo U('Ajax/getRemind');?>
" stateurl="<?php echo U('Ajax/getRemindState');?>
"></a>
		<div class="subpanel"><h3><span> &ndash; </span><?php echo $_smarty_tpl->tpl_vars['lang']->value['remind_info'];?>
</h3><ul style="border: 1px solid #2C6A9E;width:128px;"></ul></div>
	</li>
	<li id="toolbar_lang">
		<a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['curr_lang'];?>
+</a>
		<div class="subpanel">
		<h3><span> &ndash; </span><?php echo $_smarty_tpl->tpl_vars['lang']->value['select_lang'];?>
</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
			<?php  $_smarty_tpl->tpl_vars['l_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['l_item']->_loop = false;
 $_smarty_tpl->tpl_vars['l_key'] = new Smarty_Variable;
 $_from = C('SYSTEM_LANG'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['l_item']->key => $_smarty_tpl->tpl_vars['l_item']->value){
$_smarty_tpl->tpl_vars['l_item']->_loop = true;
 $_smarty_tpl->tpl_vars['l_key']->value = $_smarty_tpl->tpl_vars['l_item']->key;
?>
				<li><a href="?l=<?php echo $_smarty_tpl->tpl_vars['l_key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['l_item']->value;?>
</a></li>
			<?php } ?>
	    </ul>
	    </div>
	</li>
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['user_type']==2){?>
	<li><a href="javascript:void(0)" onclick="addTab('<?php echo U("/Factory/setting/id/".($_smarty_tpl->tpl_vars['login_user']->value['company_id']));?>
','<?php echo $_smarty_tpl->tpl_vars['lang']->value['company_setting'];?>
',1)"><?php echo $_smarty_tpl->tpl_vars['lang']->value['company_setting'];?>
</a></li>
	<?php }?>
	<li><a href="javascript:;" onclick="loadTab()"><span class="icon icon-refresh"></span><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_refresh'];?>
</a></li>
	<li><a href="javascript:;" id="close_all" onclick="window.location.reload();"><span class="icon icon-list-del"></span><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_close_all'];?>
</a></li>
	<li id="toolbar_help"><a href="javascript:void(0)"><span class="icon icon-help"></span><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_help'];?>
+</a>
		<div class="subpanel">
		<h3 ><span> &ndash; </span><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_help'];?>
</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
		<?php if ($_smarty_tpl->tpl_vars['super_admin']->value){?><li><a href="./admin.php" target="_blank">后台管理</a></li><?php }?>
		<!--li><a href="__APP_ROOT__/invoice.php" target="_blank">发票系统</a></li-->
		   <li><a href="javascript:void(0)"  onclick="setIndex()"><?php echo $_smarty_tpl->tpl_vars['lang']->value['setindex'];?>
</a></li>
		   <li><a href="javascript:;" onclick="addTab('<?php echo U("Public/shortMenu");?>
','<?php echo $_smarty_tpl->tpl_vars['lang']->value['title_key'];?>
')"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_key'];?>
</a></li>
		   <li><a href="javascript:void(0)" onclick="getManual();"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_help'];?>
</a></li>
		   <li><a href="javascript:void(0)" onclick="addTab('<?php echo U("Public/service");?>
','<?php echo $_smarty_tpl->tpl_vars['lang']->value['service'];?>
')"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_customer'];?>
</a></li>
		   <?php if (C('SHOW_GUIDE')==1){?>
		   <li><a href="javascript:void(0)"  onclick="guide();"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_wizard'];?>
</a></li>
		   <?php }?>
		   <li><a href="javascript:void(0)" onclick="addTab('<?php echo U("User/editPsw");?>
','<?php echo $_smarty_tpl->tpl_vars['lang']->value['edit_psw'];?>
',1)"><?php echo $_smarty_tpl->tpl_vars['lang']->value['edit_psw'];?>
</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop32.exe" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_print_32'];?>
</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop64.exe" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_print_64'];?>
</a></li>
		   <?php if ($_smarty_tpl->tpl_vars['super_admin']->value||$_smarty_tpl->tpl_vars['login_user']->value['user_type']==2){?>
		   <li><a href="__PUBLIC__/Data/Eda_Warehousing_Sellers_Operating_Manual.pdf" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['sellers_operating_manual'];?>
</a></li>
		   <li><a href="__PUBLIC__/Data/EA_Account_Binding_Instructions.pdf" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['ea_account_binding_instructions'];?>
</a></li>
		   <li><a href="__PUBLIC__/Data/Eda_Warehousing_API_Documentation.pdf" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['api_documentation'];?>
</a></li>
		   <?php }?>
	       <li><a href="javascript:void(0)" onclick="addTab('<?php echo U("User/setFormat");?>
','<?php echo $_smarty_tpl->tpl_vars['lang']->value['setformat'];?>
',1)"><?php echo $_smarty_tpl->tpl_vars['lang']->value['setformat'];?>
</a></li>
	    </ul>
	    </div>
	</li>
	<li><a href='<?php echo U("Public/logout");?>
' target="_top" class="b_right"><?php echo $_smarty_tpl->tpl_vars['lang']->value['title_logout'];?>
</a></li>
	</ul>
	</div>
	<div class="search">
	<div><input type="text" id="toolbar_product_input" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['input_pno'];?>
" onfocus="javascript:if(this.value=='<?php echo $_smarty_tpl->tpl_vars['lang']->value['input_pno'];?>
'){ this.value='';}" onkeyup="$.showToolsBarProduct(this)"></span>
	<div class="zoom none"><img id="toolbar_product_search" src="__PUBLIC__/Images/Default/icon_search.png" onclick="javascript:$.getProductInfo('<?php echo $_smarty_tpl->tpl_vars['lang']->value['p_detail_info'];?>
',this);"></div>
	</div>

</div></div>
</li>

</ul>
</div>

<div id="toolbarProduct" class="toolbar_product"></div>
<div class="statisticsWindow" id="toolbarTodayRemind"></div><?php }} ?>