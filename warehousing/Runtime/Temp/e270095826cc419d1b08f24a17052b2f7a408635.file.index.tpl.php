<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:49:53
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/ComplexOrder/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140894412358f6c24111ce44-64021244%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e270095826cc419d1b08f24a17052b2f7a408635' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/ComplexOrder/index.tpl',
      1 => 1492482591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140894412358f6c24111ce44-64021244',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6c2411d20a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c2411d20a')) {function content_58f6c2411d20a($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
if (!is_callable('smarty_function_note')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.note.php';
?><?php echo smarty_function_wz(array(),$_smarty_tpl);?>

<form method="POST" action="<?php echo U("ComplexOrder/".(@ACTION_NAME));?>
" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label ><?php echo $_smarty_tpl->tpl_vars['lang']->value['deal_no'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['like']['sale_order_no'];?>
" type="text" name="sale_order[like][sale_order_no]" url="<?php echo U('/AutoComplete/saleDealNo');?>
" jqac>
		</dt>
		<dt>
			<label ><?php echo $_smarty_tpl->tpl_vars['lang']->value['orderno'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['like']['order_no'];?>
" type="text" name="sale_order[like][order_no]" url="<?php echo U('/AutoComplete/saleOrderNo');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['warehouse_name'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['warehouse_id'];?>
" type="hidden" name="sale_order[query][warehouse_id]">
			<input value="<?php echo $_POST['temp']['warehouse_name_use'];?>
" name="temp[warehouse_name_use]" type='text' url="<?php echo U('/AutoComplete/warehouseNameUse');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['product_id'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_detail']['query']['product_id'];?>
" name="sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_date_from'];?>
：</label>
			<input type="text" name="sale_order[date][needdate_from_order_date]" value="<?php echo $_POST['date']['needdate_from_order_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
			<input type="text" name="sale_order[date][needdate_to_order_date]" value="<?php echo $_POST['date']['needdate_to_order_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>  
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['delivery_personnel'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['add_user'];?>
" type="hidden" name="sale_order[query][add_user]">
			<input value="<?php echo $_POST['temp']['add_real_name'];?>
" name="temp[add_real_name]" type='text' url="<?php echo U('/AutoComplete/addUserRealName');?>
" jqac>
		</dt>
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
<?php echo smarty_function_note(array(),$_smarty_tpl);?>

<div id="print" class="width98">
<?php echo $_smarty_tpl->getSubTemplate ("ComplexOrder/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div> <?php }} ?>