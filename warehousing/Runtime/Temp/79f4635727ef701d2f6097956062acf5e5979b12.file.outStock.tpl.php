<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:49:41
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:87440345658f6c23533e186-96796510%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79f4635727ef701d2f6097956062acf5e5979b12' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStock.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '87440345658f6c23533e186-96796510',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'w_id' => 0,
    'w_name' => 0,
    'rs' => 0,
    'verifyType' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6c23545296',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c23545296')) {function content_58f6c23545296($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
?><?php echo smarty_function_wz(array(),$_smarty_tpl);?>

<br>
<form method="POST" action="<?php echo U("SaleOrder/".(@ACTION_NAME));?>
" id="search_form" beforesubmit="checkSearchForm" >
__SEARCH_START__
	<dl>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['custom_barcode'];?>
：</label>
			<input id="custom_barcode" value="" name="query[p.custom_barcode]" value="<?php echo $_POST['query']['p.custom_barcode'];?>
" type='text' class="spc_input valid-required">__*__
		</dt>  
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['warehouse_name'];?>
：</label>
			<?php if ($_smarty_tpl->tpl_vars['w_id']->value>0){?>
				<input type="hidden" name="query[a.warehouse_id]" value="<?php echo $_smarty_tpl->tpl_vars['w_id']->value;?>
">
				<input name="temp[w_name]" url="<?php echo U('AutoComplete/saleWarehouse');?>
" value="<?php echo $_smarty_tpl->tpl_vars['w_name']->value;?>
" disabled="disabled" class="spc_input disabled" />	
			<?php }else{ ?>
            <input id="warehouse_id" value="<?php echo $_POST['query']['a.warehouse_id'];?>
" type="hidden" name="query[a.warehouse_id]" onchange="getExpressCompany(this)" class="valid-required">
            <input id="warehouse_name" value="<?php echo $_POST['temp']['warehouse_name_use'];?>
" name="temp[warehouse_name_use]" type='text' url="<?php echo U('/AutoComplete/saleWarehouse');?>
" jqac>__*__
					
			<?php }?>
		</dt>
        <dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_type'];?>
：</label>
			<?php echo smarty_function_select(array('data'=>C('SHIPPING_TYPE'),'name'=>"query[e.shipping_type]",'value'=>($_POST['query']['e.shipping_type']),'empty'=>true,'combobox'=>1),$_smarty_tpl);?>

        </dt>        
        <dt>
        <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['express'];?>
：</label>
        <span id="company">
            <input type="hidden" name="query[e.company_id]" id="company_id" value="<?php echo $_POST['query']['e.company_id'];?>
">
            <input type="text" name="temp[company_name]" value="<?php echo $_POST['temp']['company_name'];?>
" id="company_name" url="<?php echo U('/AutoComplete/companyUse');?>
" where="1" jqac/>
        </span>
        </dt>
        <dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_way'];?>
：</label>
            <input value="<?php echo $_POST['query']['a.express_id'];?>
" type="hidden" name="query[a.express_id]" >
            <input value="<?php echo $_POST['temp']['express_name'];?>
" name="temp[express_name]" type='text' url="<?php echo U('/AutoComplete/shipping');?>
" jqac>
        </dt>
		<dt>
		 <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_type'];?>
：<label>
            <input type="hidden" id="order_type" name="query[a.order_type]" value="<?php echo $_POST['query']['a.order_type'];?>
" />
            <input url="<?php echo U('AutoComplete/orderTypeTag');?>
" value="" class="spc_input" jqac/>
		</dt>  
        <dt>
		 <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_type_change'];?>
：<label>
            <?php echo smarty_function_select(array('data'=>C('YES_NO'),'value'=>0,'name'=>"order_type_change",'initvalue'=>$_POST['order_type_change'],'empty_value'=>false,'combobox'=>'1'),$_smarty_tpl);?>

		</dt>
        <dt>
		 <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['is_registered'];?>
：<label>
            <?php echo smarty_function_select(array('data'=>C('YES_NO'),'value'=>0,'name'=>"is_registered",'initvalue'=>$_POST['is_registered'],'empty_value'=>false,'combobox'=>'1'),$_smarty_tpl);?>

		</dt>
        <dt>
		 <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['out_stock_type'];?>
：<label>
            <?php echo smarty_function_select(array('data'=>C('SALE_ORDER_OUT_STOCK_TYPE'),'value'=>$_POST['out_stock_type'],'name'=>"out_stock_type",'initvalue'=>'-2','combobox'=>''),$_smarty_tpl);?>

		</dt>
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>

<div id="print" class="width98">
<?php if ($_smarty_tpl->tpl_vars['rs']->value['id']>0&&$_smarty_tpl->tpl_vars['rs']->value['out_stock_type']>0){?>
<?php echo $_smarty_tpl->getSubTemplate ('SaleOrder/outStockInfo.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
</div>

<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['verifyType']->value=='1'){?>
$dom.find("#barcode").focus();
<?php }else{ ?>
$dom.find("#custom_barcode").focus();
<?php }?>
</script><?php }} ?>