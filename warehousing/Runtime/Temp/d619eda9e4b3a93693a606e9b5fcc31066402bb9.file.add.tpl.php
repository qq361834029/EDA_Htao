<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:39:06
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Picking/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:179684576658f6bfbaeb8924-12904844%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd619eda9e4b3a93693a606e9b5fcc31066402bb9' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Picking/add.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179684576658f6bfbaeb8924-12904844',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'file_tocken' => 0,
    'lang' => 0,
    'w_id' => 0,
    'w_name' => 0,
    'dateFmt' => 0,
    'rs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bfbb0c63e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bfbb0c63e')) {function content_58f6bfbb0c63e($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
?><form action="<?php echo U('Picking/insert');?>
" method="POST" onsubmit="return false;">
<?php echo smarty_function_wz(array('action'=>"save,list,reset"),$_smarty_tpl);?>

<input type="hidden" name="tocken" value="<?php echo $_smarty_tpl->tpl_vars['file_tocken']->value;?>
">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4"><?php echo $_smarty_tpl->tpl_vars['lang']->value['basic_info'];?>
</th>
		</tr>
		<tr>
			<td colspan="4">
				<div class="basic_tb">  
					<ul> 
						<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['warehouse_name'];?>
：
							<input type="hidden" id="warehouse_id" onchange="filterPickingSaleOrderNO();filterExpressWay();getExpressCompany(this);" name="warehouse_id" value="<?php echo $_smarty_tpl->tpl_vars['w_id']->value;?>
" />
                            <input url="<?php echo U('AutoComplete/saleWarehouse');?>
" value="<?php echo $_smarty_tpl->tpl_vars['w_name']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['w_id']->value>0){?>disabled="disabled" class="spc_input disabled"<?php }else{ ?>class="spc_input" jqac<?php }?> />__*__
						</li>
                        <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['express'];?>
：
                            <input type="hidden" name="company_id" id="company_id"  onchange="controlPick();" >
                            <input type="text" name="company_name" id="company_name" url="<?php echo U('/AutoComplete/companyUse');?>
" where="1" jqac/>
                        </li>
                        <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_way'];?>
：						 
						    <input type="hidden" onchange="controlPick();"  name="express_id" id="express_id">
						    <input id="express_name" name="express_way" url="<?php echo U('/AutoComplete/shippingName');?>
" where="" jqac>						 								 						
						</li>                        
						<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['factory_name'];?>
：
								<input type="hidden" onchange="filterPickingSaleOrderNO();" name="sale[query][factory_id]" id="factory_id">
								<input id="factory_name" url="<?php echo U('/AutoComplete/factoryEmail');?>
" jqac>							
						</li>
						<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['out_stock_type'];?>
：
								<?php echo smarty_function_select(array('data'=>C('ORDER_OUT_STOCK_TYPE'),'name'=>"sale[query][out_stock_type]",'onchange'=>"filterPickingSaleOrderNO();",'id'=>"out_stock_type",'combobox'=>1),$_smarty_tpl);?>
							
						</li>
                        <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['is_warehouse_pickup'];?>
：

                            <input id="is_warehouse_pickup" type="checkbox" name="sale[is_warehouse_pickup]" onclick="isWareHousePickUp();" />
						</li>
                        <li style="display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['deal_no'];?>
：

                            <input type="text" id="sale_order_no" value="<?php echo $_POST['sale']['query']['sale_order_no'];?>
" name="sale[query][sale_order_no]" url="<?php echo U('AutoComplete/saleDealNoExpress');?>
" where="<?php ob_start();?><?php echo C('ONESELF_TAKE');?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo C('SALE_ORDER_STATE_EXPORTING');?>
<?php $_tmp2=ob_get_clean();?><?php echo urlencode(" b.company_id = '".$_tmp1."' and a.sale_order_state ='".$_tmp2."'");?>
" init_where="<?php ob_start();?><?php echo C('ONESELF_TAKE');?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo C('SALE_ORDER_STATE_EXPORTING');?>
<?php $_tmp4=ob_get_clean();?><?php echo urlencode(" b.company_id = '".$_tmp3."' and a.sale_order_state ='".$_tmp4."'");?>
" jqac />

                        </li>
                        <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_type'];?>
：
                            <input type="hidden" id="order_type" name="sale[query][order_type]" value="" />
                            <input url="<?php echo U('AutoComplete/orderTypeTag');?>
" value="" class="spc_input" jqac/>
						</li>
                        <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['doc_date'];?>
：
							<?php if (C('digital_format')=='eur'){?>
								<?php $_smarty_tpl->tpl_vars['dateFmt'] = new Smarty_variable('dd/MM/yy HH:mm:ss', null, 0);?>
							<?php }else{ ?>
								<?php $_smarty_tpl->tpl_vars['dateFmt'] = new Smarty_variable('yyyy-MM-dd HH:mm:ss', null, 0);?>
							<?php }?>
                            <input type="text" id='date_from' name="sale[date][s.from_create_time]" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'<?php echo $_smarty_tpl->tpl_vars['dateFmt']->value;?>
' })" />
							&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['lang']->value['to_date'];?>
&nbsp;&nbsp;
							<input type="text" id='date_to' name="sale[date][s.to_create_time]" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'<?php echo $_smarty_tpl->tpl_vars['dateFmt']->value;?>
' })" />
						</li>
					</ul>
				</div>
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4"><?php echo $_smarty_tpl->tpl_vars['lang']->value['detail_info'];?>
</th>
		</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%"><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80"><?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_comments'];?>
</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	 		
    </tbody>
</table>
<?php echo smarty_function_staff(array(),$_smarty_tpl);?>

</div>
</form>
<?php }} ?>