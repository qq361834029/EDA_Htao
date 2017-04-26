<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:38:33
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:199622381958f6bf992fc4b2-68975564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54a17609761c210dfb4598881c742d3cbf145d14' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/index.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199622381958f6bf992fc4b2-68975564',
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
  'unifunc' => 'content_58f6bf994acec',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bf994acec')) {function content_58f6bf994acec($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
if (!is_callable('smarty_function_note')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.note.php';
?><?php echo smarty_function_wz(array(),$_smarty_tpl);?>

<form method="POST" action="<?php echo U("SaleOrder/".(@ACTION_NAME));?>
" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="<?php echo $_smarty_tpl->tpl_vars['rand']->value;?>
">
<input type="hidden" name="mac_address" id="mac_address" value="" class="spc_input">
	<dl>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['deal_no'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['sale_order_no'];?>
" type="text" name="sale_order[query][sale_order_no]" url="<?php echo U('/AutoComplete/saleDealNo');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['orderno'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['order_no'];?>
" type="text" name="sale_order[query][order_no]" url="<?php echo U('/AutoComplete/saleOrderNo');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['clientname'];?>
：</label>
			<input value="<?php echo $_POST['client']['like']['comp_name'];?>
" type='text' name="client[like][comp_name]" class="spc_input">
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['belongs_country'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_addition']['like']['country_name'];?>
" type='text' name="sale_order_addition[like][country_name]" class="spc_input">
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['consignee'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_addition']['like']['consignee'];?>
" type='text' name="sale_order_addition[like][consignee]" class="spc_input">
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['id'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_detail']['query']['product_id'];?>
" name="sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['product_no'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_detail']['query']['product_no'];?>
" type='text' name="sale_order_detail[query][product_no]" url="<?php echo U('/AutoComplete/productNo');?>
" jqac>
		</dt>
        <dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['product_barcode'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_detail']['query']['custom_barcode'];?>
" type='text' name="sale_order_detail[query][custom_barcode]" url="<?php echo U('/AutoComplete/productBarcode');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_way'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['express_id'];?>
" type="hidden" name="sale_order[query][express_id]">
			<input value="<?php echo $_POST['temp']['express_name'];?>
" name="temp[express_name]" type='text' url="<?php echo U('/AutoComplete/shipping');?>
" jqac>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['track_no'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['track_no'];?>
" type='text' name="sale_order[query][track_no]" url="<?php echo U('/AutoComplete/trackNo');?>
" jqac>
		</dt>
		<?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('WAREHOUSE_ROLE_TYPE')){?>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_warehouse'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['sale_order_warehouse_id'];?>
" type="hidden" name="sale_order[query][sale_order.warehouse_id]">
			<input value="<?php echo $_POST['temp']['warehouse_name_use'];?>
" name="temp[warehouse_name_use]" type='text' url="<?php echo U('/AutoComplete/saleWarehouse');?>
" jqac>
		</dt>
		<?php }?>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_date_from'];?>
：</label>
			<input type="text" name="sale_order[date][needdate_from_order_date]" value="<?php echo $_POST['sale_order']['date']['needdate_from_order_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
			<input type="text" name="sale_order[date][needdate_to_order_date]" value="<?php echo $_POST['sale_order']['date']['needdate_to_order_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_type'];?>
：</label>
            <input type="hidden" value=""<?php echo $_POST['sale_order']['query']['order_type'];?>
" name="sale_order[query][order_type]" id='order_type' value="<?php echo $_POST['return_sale_order_detail']['query']['order_type'];?>
" class="spc_input">
            <input type='text' name="temp[order_type_name]" id='order_type_name' <?php echo $_POST['temp']['order_type_name'];?>
 url="<?php echo U('/AutoComplete/orderTypeTag');?>
" jqac>
        </dt>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['state'];?>
：</label>
			<?php echo smarty_function_select(array('value'=>$_POST['sale_order']['query']['sale_order_state'],'data'=>C('SALE_ORDER_STATE'),'name'=>'sale_order[query][sale_order_state]','id'=>'sale_order_state','initvalue'=>"1",'combobox'=>"1"),$_smarty_tpl);?>

		</dt>
		<?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('SELLER_ROLE_TYPE')){?>
		<dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['belongs_seller'];?>
：</label>
			<input value="<?php echo $_POST['sale_order']['query']['sale_order_factory_id'];?>
" type='hidden' name="sale_order[query][sale_order.factory_id]">
			<input value="<?php echo $_POST['temp']['factory'];?>
" name="temp[factory]" type='text' url="<?php echo U('/AutoComplete/factory');?>
" jqac>
		</dt>
		<?php }?>
        <dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['out_stock_date'];?>
：</label>
			<input type="text" name="sale_order[date][mt_send_date]" value="<?php echo $_POST['sale_order']['date']['mt_send_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
			<input type="text" name="sale_order[date][lt_send_date]" value="<?php echo $_POST['sale_order']['date']['lt_send_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
        <dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['postcode'];?>
：</label>
			<input value="<?php echo $_POST['sale_order_addition']['query']['post_code'];?>
" type='text' name="sale_order_addition[query][post_code]" class="spc_input">
		</dt>
        <dt>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['return_sale_date_from'];?>
：</label>
			<input type="text" name="return_sale_order[date][mt_return_order_date]" value="<?php echo $_POST['date']['needdate_from_insert_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
			<input type="text" name="return_sale_order[date][lt_return_order_date]" value="<?php echo $_POST['date']['needdate_to_insert_date'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
        <dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['has_track_no'];?>
：</label>
            <?php echo smarty_function_select(array('data'=>C('YES_NO'),'value'=>$_POST['has_track_no'],'name'=>"has_track_no",'initvalue'=>-2,'combobox'=>''),$_smarty_tpl);?>

		</dt>
        <dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['insure'];?>
：</label>
            <?php echo smarty_function_select(array('data'=>C('IS_INSURE'),'value'=>$_POST['is_insure'],'name'=>"sale_order[query][is_insure]",'initvalue'=>'-2','combobox'=>''),$_smarty_tpl);?>

        </dt>
        <dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['out_stock_type'];?>
：</label>
            <?php echo smarty_function_select(array('data'=>C('SALE_ORDER_OUT_STOCK_TYPE'),'value'=>$_POST['out_stock_type'],'name'=>"sale_order[query][out_stock_type]",'initvalue'=>'-2','combobox'=>''),$_smarty_tpl);?>

        </dt>
        <dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['last_operation'];?>
：</label>
            <input type="text" name="sale_order[date][sale_order.mt_update_time]" value="<?php echo $_POST['sale_order']['date']['mt_update_time'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
</label>
            <input type="text" name="sale_order[date][sale_order.lt_update_time]" value="<?php echo $_POST['sale_order']['date']['lt_update_time'];?>
" class="Wdate spc_input_data" onClick="WdatePicker()"/>
        </dt>
		<dt>
            <label><?php echo $_smarty_tpl->tpl_vars['lang']->value['consigner'];?>
：</label>
            <input value="<?php echo $_POST['state_log']['query']['user_id'];?>
" type="hidden" name="state_log[query][user_id]">
			<input value="<?php echo $_POST['temp']['consigner'];?>
" name="temp[consigner]" type='text' url="<?php echo U('/AutoComplete/saleOrderConsigner');?>
" jqac>
        </dt>
	</dl>
	<input type="hidden" name="date_key" value="4">
__SEARCH_END__
</form>
<?php echo smarty_function_note(array('batch_upload'=>true,'export'=>true,'all_delete'=>$_smarty_tpl->tpl_vars['login_user']->value['role_type']==C('SELLER_ROLE_TYPE')),$_smarty_tpl);?>

<!--export=true combine=$login_user.role_type==C('SELLER_ROLE_TYPE')-->
__SCROLL_BAR_START__
    <div id="print" class="width98">
        <?php echo $_smarty_tpl->getSubTemplate ("SaleOrder/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </div>
__SCROLL_BAR_END__
<script>
	$(document).ready(function(){
		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$dom.find('#mac_address'));
	});
</script><?php }} ?>