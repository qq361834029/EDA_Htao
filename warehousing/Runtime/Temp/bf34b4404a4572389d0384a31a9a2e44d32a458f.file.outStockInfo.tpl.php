<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:51:16
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStockInfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147068451958f6c2940e4134-42417584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf34b4404a4572389d0384a31a9a2e44d32a458f' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStockInfo.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147068451958f6c2940e4134-42417584',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'verifyType' => 0,
    'product_id' => 0,
    'rs' => 0,
    'color' => 0,
    'lang' => 0,
    'initvalue' => 0,
    'filter' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6c29437b4a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c29437b4a')) {function content_58f6c29437b4a($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
?><?php if ($_smarty_tpl->tpl_vars['verifyType']->value!='1'){?>

<script type="text/javascript">
$dom.find("#barcode").focus();
$dom.find("input[jqac]").each(function(){$(this).initAutocomplete();});
$dom.find("select[combobox]").each(function(){$(this).combobox();});
$dom.find("form[id!='search_form']").sendForm();
var detail_list = $('.detail_list');
if(detail_list){
	detail_list.bandCache();
	detail_list.bandTotalMethod();//明细表绑定合计事件
	detail_list.bandProductMethod();//明细表绑定合计事件
}
$dom.find('.list').tableClick(); 
if(detail_list){
	var options = {target: $dom.find("#print:first"),success:searchSuccess};
	options['beforeSubmit'] = function(){
	    $dom.find("#_page_qtp").remove();
	    $.loading();
	};
}
$("#tips").fadeOut(100);
$.removeLoading();
</script>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['product_id']->value>0){?>
<script type="text/javascript">
    autoQuantityPlus('<?php echo $_smarty_tpl->tpl_vars['product_id']->value;?>
');
</script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['rs']->value['sale_order_state']==C('SALE_ORDER_DELETED')){?>
    <?php $_smarty_tpl->tpl_vars['color'] = new Smarty_variable('style="background:#FFFFE0;"', null, 0);?>
<?php }?>
<form action="<?php echo U('SaleOrder/update');?>
" method="POST" beforeSubmit="checkSaleaState">
<div class="add_box" <?php echo $_smarty_tpl->tpl_vars['color']->value;?>
>
<?php if ($_smarty_tpl->tpl_vars['rs']->value['sale_order_state']==C('SALE_ORDER_DELETED')){?>
    <?php echo smarty_function_wz(array('action'=>'save,reset','button'=>true,'save_name'=>'submit'),$_smarty_tpl);?>

<?php }else{ ?>
    <?php if ($_smarty_tpl->tpl_vars['rs']->value['express_enable_print']==1){?>
        <?php if ($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']==1){?>
            <?php echo smarty_function_wz(array('action'=>'save,save_print,reset,print_waybill','button'=>true,'save_name'=>'ship'),$_smarty_tpl);?>

        <?php }elseif($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']>1){?>
            <?php echo smarty_function_wz(array('action'=>'save,save_print,temp,reset,print_waybill','button'=>true,'save_name'=>'ship'),$_smarty_tpl);?>

        <?php }?>
    <?php }else{ ?>
        <?php if ($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']==1){?>
            <?php echo smarty_function_wz(array('action'=>'save,reset,print_waybill','button'=>true,'save_name'=>'ship'),$_smarty_tpl);?>

        <?php }elseif($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']>1){?>
            <?php echo smarty_function_wz(array('action'=>'save,temp,reset,print_waybill','button'=>true,'save_name'=>'ship'),$_smarty_tpl);?>

        <?php }?>       
    <?php }?>
<?php }?>
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
	<tr><th><input type="hidden" name="mac_address" id="mac_address" value="" class="spc_input">
			<div class="titleth">
				<div class="titlefl"><?php echo $_smarty_tpl->tpl_vars['lang']->value['basic_info'];?>
</div>
                    <div class="afr">
                        <?php echo $_smarty_tpl->tpl_vars['lang']->value['deal_no'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['sale_order_no'];?>

                        <?php if ($_smarty_tpl->tpl_vars['rs']->value['sale_order_state']!=C('SALE_ORDER_DELETED')){?>
                            <input style="width:50px;" type="button" class="button_new" value="<?php echo L('copy');?>
" id="d_clip_button_<?php echo $_smarty_tpl->tpl_vars['rs']->value['id'];?>
" 
                            data-clipboard-target="sale_order_no_<?php echo $_smarty_tpl->tpl_vars['rs']->value['id'];?>
" />
                        <?php }?>
                    </div>
			</div>
	</th></tr> 
	<tr><td><div class="basic_tb">
		<ul> 
			<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['sale_order_no'];?>
" id="sale_order_no_<?php echo $_smarty_tpl->tpl_vars['rs']->value['id'];?>
"/>
			<input type="hidden" name="id" id="id" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['id'];?>
"/>  
			<input type="hidden" name="lock_version" id="lock_version" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['lock_version'];?>
">
			<?php if ($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']>0){?>
			<input type="hidden" name="out_stock_type" id="out_stock_type" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['out_stock_type'];?>
"/>  
			<?php }?>
			<input type="hidden" name="verifyType" value="<?php echo $_smarty_tpl->tpl_vars['verifyType']->value;?>
">
			<input type="hidden" name="client_id" id="client_id" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['client_id'];?>
">
			<input type="hidden" name="from_type" id="from_type" value="out_stock">
			<input type="hidden" name="flow" id="flow" value="sale">
			<input type="hidden" name="order_type" id='order_type' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['order_type'];?>
">
			<input type="hidden" name="warehouse_id" id='warehouse_id' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['warehouse_id'];?>
">
			<input type="hidden" name="is_registered" id='is_registered' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['is_registered'];?>
">
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['orderno'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['new_order_no'];?>

				<input type="hidden" name="order_no" id='order_no' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['order_no'];?>
">
			</li>
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_date'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['fmd_order_date'];?>

				<input type="hidden" name="order_date"  id="order_date" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['fmd_order_date'];?>
">
			</li> 
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_way'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_name'];?>

				<input type="hidden" name="express_id" id='express_id' onchange="getExpressInfo();" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
">
				<img pid="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
			</li>
            <?php if ($_smarty_tpl->tpl_vars['rs']->value['shipping_type']==C('SHIPPING_TYPE_SURFACE')){?>
            <li class="afr">
                <?php echo $_smarty_tpl->tpl_vars['lang']->value['delivery_costs'];?>
:<?php echo $_smarty_tpl->tpl_vars['rs']->value['expected_delivery_costs'];?>

            </li>
            <?php }?>
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['track_no'];?>
：
				<input type="text" name="track_no" id='track_no' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['track_no'];?>
" <?php if ($_smarty_tpl->tpl_vars['rs']->value['Labelurl']){?>class="spc_input disabled" readonly="readonly"<?php }else{ ?>class="spc_input"<?php }?>>
			</li>
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['package'];?>
：
                <input type="hidden" id="package_id" onchange="weightByPackage(this)" name="package_id" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['package_id'];?>
">
				<input type="text" name="temp[package_name]" url="<?php echo U('AutoComplete/packageNameUse');?>
" where="warehouse_id=<?php echo $_smarty_tpl->tpl_vars['rs']->value['warehouse_id'];?>
"  value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['package_name'];?>
" jqac />
			</li>
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_order_state'];?>
：
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['sale_order_state']==C('SALE_ORDER_DELETED')){?>
                    <?php $_smarty_tpl->tpl_vars['initvalue'] = new Smarty_variable(C('SALEORDER_OBSOLETE'), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['filter'] = new Smarty_variable(C('SALE_ORDER_OUT_INFO_FILTER_DELETED'), null, 0);?>
                <?php }else{ ?>
                    <?php $_smarty_tpl->tpl_vars['initvalue'] = new Smarty_variable(C('SHIPPED'), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['filter'] = new Smarty_variable(C('SALE_ORDER_OUT_INFO_FILTER'), null, 0);?>
                <?php }?>
			<?php echo smarty_function_select(array('data'=>C('SALE_ORDER_STATE'),'name'=>"sale_order_state",'id'=>'sale_order_state','onchange'=>'changeSaveTitle(this)','combobox'=>'','empty'=>true,'initvalue'=>$_smarty_tpl->tpl_vars['initvalue']->value,'filter'=>$_smarty_tpl->tpl_vars['filter']->value),$_smarty_tpl);?>

			__*__
			</li>
			<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['total_weight'];?>
：
                <span id="total_weight"><?php echo $_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_unit_weight'];?>
</span>
			</li>
			<?php if ($_smarty_tpl->tpl_vars['rs']->value['is_registered']==1){?>
			<li class="red"><?php echo $_smarty_tpl->tpl_vars['lang']->value['is_registered'];?>
：
				<span id="is_registered"><?php echo $_smarty_tpl->tpl_vars['rs']->value['dd_is_registered'];?>
</span>
			</li>
			<?php }?>
            <li id="aliexpress"  <?php if ($_smarty_tpl->tpl_vars['rs']->value['order_type']!=C('ALIEXPRESS')){?>style="display: none;"<?php }?>>
                <?php echo $_smarty_tpl->tpl_vars['lang']->value['aliexpress_token'];?>
：
                <?php echo $_smarty_tpl->tpl_vars['rs']->value['aliexpress_token'];?>

		<input type="hidden" name="aliexpress_token" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['aliexpress_token'];?>
" />
            </li>
            <li <?php if ($_smarty_tpl->tpl_vars['rs']->value['is_insure']==1){?>style="color:red;font-weight:bolder;"<?php }?>>
                <?php echo $_smarty_tpl->tpl_vars['lang']->value['insure'];?>
：
                <?php echo $_smarty_tpl->tpl_vars['rs']->value['dd_is_insure'];?>

            </li>
            <?php if ($_smarty_tpl->tpl_vars['rs']->value['is_insure']==1){?>
                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['insure_price'];?>
：
                    <input type="text" name="insure_price" id='insure_price' value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['edml_insure_price'];?>
" class="spc_input"><?php echo $_smarty_tpl->tpl_vars['rs']->value['w_currency_no'];?>

                </li>
            <?php }?>
		</ul>
	</div></td></tr>   
	<tr><th>
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_order_info'];?>
&nbsp;&nbsp;&nbsp;
		<?php if ($_smarty_tpl->tpl_vars['verifyType']->value=='1'){?>
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['product_id'];?>
：<input type="text" name="input_product_id" id='input_product_id' value="" class="spc_input">
		<span class="tred" id="input_product_id_error"></span>
		<?php }?>
	</th></tr>   
	<tr><td><?php echo $_smarty_tpl->getSubTemplate ("SaleOrder/outStockDetail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</td></tr>
	<tr><td>&nbsp;</td></tr>   
	<tr><th><?php echo $_smarty_tpl->tpl_vars['lang']->value['client_info'];?>
</th></tr> 
	<tr><td>
		<table width="80%" cellspacing="0" cellpadding="0" border="0">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['company_name'];?>
" id='company_name' name="addition[1][company_name]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['consignee'];?>
" id='consignee' name="addition[1][consignee]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['transmit_name'];?>
" id='transmit_name' name="addition[1][transmit_name]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['country_id'];?>
" id="country_id" name="addition[1][country_id]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['city_name'];?>
" id="city_name" name="addition[1][city_name]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['country_name'];?>
" id="country_name" name="addition[1][country_name]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['tax_no'];?>
" id='tax_no' name="addition[1][tax_no]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['email'];?>
" id='email' name="addition[1][email]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_address'];?>
" id="address" name="addition[1][address]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_address2'];?>
" id="address2" name="addition[1][address2]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['post_code'];?>
" id='post_code' name="addition[1][post_code]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['mobile'];?>
" id='mobile' name="addition[1][mobile]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['fax'];?>
" id='fax' name="addition[1][fax]">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['addition_id'];?>
"  name="addition[1][id]">
		
		<tbody>
			<tr>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						

						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['consignee'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['consignee'];?>
</td>
						</tr>
						<!--tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['transmit_name'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['transmit_name'];?>
</td>
						</tr-->
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['belongs_country'];?>
：</td>
							<td class="t_left">
								<?php echo $_smarty_tpl->tpl_vars['rs']->value['country_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['rs']->value['abbr_district_name'];?>
 
							</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['belongs_city'];?>
：</td>
							<td class="t_left">
								<?php echo $_smarty_tpl->tpl_vars['rs']->value['city_name'];?>

							</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['email'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['email'];?>
</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['tax_no'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['tax_no'];?>
</td>
						</tr>
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td valign="top"><?php echo $_smarty_tpl->tpl_vars['lang']->value['street1'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_address'];?>
</td>
						</tr>
						<tr>
							<td valign="top"><?php echo $_smarty_tpl->tpl_vars['lang']->value['street2'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_address2'];?>
</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['street3'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['company_name'];?>
</td>
						</tr>
						
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['postcode'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['post_code'];?>
</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['client_tel'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['mobile'];?>
</td>
						</tr>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['fax'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['fax'];?>
</td>
						</tr>
                        <?php if ($_smarty_tpl->tpl_vars['rs']->value['gallery']){?>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['download_file'];?>
：</td>  
                            <td class="t_left">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rs']->value['gallery']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <div id="file_view_<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
                                        <a href=<?php echo $_smarty_tpl->tpl_vars['val']->value['file_url'];?>
 target="_blank"><?php echo $_smarty_tpl->tpl_vars['val']->value['cpation_name'];?>
</a>
                                    </div>
                                <?php } ?>
                            </td>                  
						</tr>
						<?php }?>
					</tbody>
				</table>
				</td>
				
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td id='out_stock_comments'><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
：</td>
							<td class="t_left"><textarea id="comments" name="comments" ><?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_comments'];?>
</textarea></td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
		</tbody>
		</table>
	</td></tr>                      
   </tbody>          
</table>
<?php echo smarty_function_staff(array('add_user'=>($_smarty_tpl->tpl_vars['rs']->value['add_real_name']),'create'=>($_smarty_tpl->tpl_vars['rs']->value['fmd_create_time']),'id'=>($_smarty_tpl->tpl_vars['rs']->value['add_user'])),$_smarty_tpl);?>

</div>
</form> 

<script type="text/javascript">
	//复制
	var clip_object = new ZeroClipboard( $dom.find("#d_clip_button_<?php echo $_smarty_tpl->tpl_vars['rs']->value['id'];?>
"), {
		moviePath: "__PUBLIC__/Js/ZeroClipboard/ZeroClipboard.swf"
	} );

	clip_object.on( 'complete', function(client, args) {
		noticeInfo("复制成功，复制内容为："+ args.text);
	} );

</script>
<script>
	$(document).ready(function(){
		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$dom.find('#mac_address'));
	});
</script><?php }} ?>