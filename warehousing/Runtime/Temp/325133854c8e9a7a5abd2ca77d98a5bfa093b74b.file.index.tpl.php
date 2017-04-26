<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:38:20
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:103922031558f6bf8ce0c177-92303422%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '325133854c8e9a7a5abd2ca77d98a5bfa093b74b' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/index.tpl',
      1 => 1492482589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '103922031558f6bf8ce0c177-92303422',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rand' => 0,
    'lang' => 0,
    'login_user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bf8ce96f0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bf8ce96f0')) {function content_58f6bf8ce96f0($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
if (!is_callable('smarty_function_note')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.note.php';
?><?php echo smarty_function_wz(array(),$_smarty_tpl);?>

<form method="POST" action="<?php echo U('PickingImport/index');?>
" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="<?php echo $_smarty_tpl->tpl_vars['rand']->value;?>
">
<dl>  
	<dt><label><?php echo $_smarty_tpl->tpl_vars['lang']->value['picking_import_no'];?>
：</label>
		<input name="query[id]" type='hidden' />
		<input name="temp[file_list_no]" url="<?php echo U('/AutoComplete/pickingImportNo');?>
" jqac>
	</dt>		
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('WAREHOUSE_ROLE_TYPE')){?>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['warehouse_name'];?>
：</label>
			<input type="hidden" id="warehouse_id" name="query[warehouse_id]" >
			<input type="text" name="temp[w_name]" url="<?php echo U('AutoComplete/saleWarehouse');?>
" jqac /> 
		</dt> 							
	<?php }?>	
	<dt class="w320">
		<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['doc_date'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['from_date'];?>
：</label>
		<input type="text" name="date[needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
		<input type="text" name="date[needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
	</dt>
	<dt class="w200">
		<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['has_undeal_quantity'];?>
：</label>
		<input type="checkbox" name="has_undeal_quantity" value="1" <?php if ($_POST['has_undeal_quantity']==1){?>checked="checked"<?php }?> />
	</dt> 	
</dl>
__SEARCH_END__
</form> 
<?php echo smarty_function_note(array('export'=>true),$_smarty_tpl);?>

<div id="print" class="width98">
<?php echo $_smarty_tpl->getSubTemplate ("PickingImport/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>  <?php }} ?>