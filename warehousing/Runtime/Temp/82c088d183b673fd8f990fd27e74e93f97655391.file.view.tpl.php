<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 05:15:28
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:107335473958f6d650053015-51240927%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82c088d183b673fd8f990fd27e74e93f97655391' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/view.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107335473958f6d650053015-51240927',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rs' => 0,
    'lang' => 0,
    'login_user' => 0,
    'admin' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6d65026b2c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6d65026b2c')) {function content_58f6d65026b2c($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
?><?php echo smarty_function_wz(array('is_update'=>$_smarty_tpl->tpl_vars['rs']->value['is_update']),$_smarty_tpl);?>

<div class="add_box" style="border: 1px solid #89A5C5;">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody> 
		<tr>
		<th>
			<div class="titleth">
				<div class="titlefl"><?php echo $_smarty_tpl->tpl_vars['lang']->value['basic_info'];?>
</div>
				<div class="afr"><?php echo $_smarty_tpl->tpl_vars['lang']->value['deal_no'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['sale_order_no'];?>
</div>
			</div>
		</th>
		</tr>
	<tr><td>
		<div class="basic_tb">
			<ul>  
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['orderno'];?>
：   <?php echo $_smarty_tpl->tpl_vars['rs']->value['order_no'];?>
</li>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['clientname'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['client_name'];?>
</li>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_date'];?>
： <?php echo $_smarty_tpl->tpl_vars['rs']->value['fmd_order_date'];?>
</li>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_type'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['order_type_name'];?>
</li>
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['order_type']==C('ALIEXPRESS')){?>
                <li>
                    <?php echo $_smarty_tpl->tpl_vars['lang']->value['aliexpress_token'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['aliexpress_token'];?>

                </li>
                <?php }?>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_warehouse'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['w_name'];?>
</li> 
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_way'];?>
：       <?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_name'];?>
</li>				
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['express_date'];?>
：	<?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_date'];?>
</li>
				<?php if ($_smarty_tpl->tpl_vars['rs']->value['company_id']==C('EXPRESS_BRT_ID')&&$_smarty_tpl->tpl_vars['rs']->value['warehouse_id']==C('EXPRESS_IT_WAREHOUSE_ID')){?>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['brt_account_no'];?>
：       <?php echo $_smarty_tpl->tpl_vars['rs']->value['brt_account_no'];?>
</li>
				<?php }?>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['is_registered'];?>
：	<?php echo $_smarty_tpl->tpl_vars['rs']->value['dd_is_registered'];?>
</li>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['track_no'];?>
：		<?php echo $_smarty_tpl->tpl_vars['rs']->value['track_no'];?>
</li>
				<?php if ($_smarty_tpl->tpl_vars['rs']->value['package_id']){?>
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['package'];?>
：	<?php echo $_smarty_tpl->tpl_vars['rs']->value['package_name'];?>
</li>
				<?php }?>				
				<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_order_state'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['dd_sale_order_state'];?>
</li>
                                <?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('SELLER_ROLE_TYPE')){?>
                                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['belongs_seller'];?>
：<?php echo $_smarty_tpl->tpl_vars['rs']->value['factory_name'];?>
</li>  
                                <?php }?>         
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['fmd_send_date']){?>
                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['out_stock_date'];?>
:<?php echo $_smarty_tpl->tpl_vars['rs']->value['fmd_send_date'];?>
</li>
                <?php if ($_smarty_tpl->tpl_vars['admin']->value&&$_smarty_tpl->tpl_vars['rs']->value['ship_cost_id']>0){?>
                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_cost_name'];?>
:<?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_cost_name'];?>
</li>
                <?php }?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['return_id']){?>
                	<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['return_sale_order_no'];?>
:<a href="javascript:;" onclick="addTab('<?php echo U("/ReturnSaleOrder/view/id/".($_smarty_tpl->tpl_vars['rs']->value['return_id']));?>
','<?php echo L("viewReturnOrder");?>
',1)"><?php echo $_smarty_tpl->tpl_vars['rs']->value['return_no'];?>
</a></li>
                <?php }?>
                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['insure'];?>
：
                    <?php echo $_smarty_tpl->tpl_vars['rs']->value['dd_is_insure'];?>

                </li>
                <?php if (($_smarty_tpl->tpl_vars['rs']->value['is_out']||$_smarty_tpl->tpl_vars['rs']->value['sale_order_state']==C('SALEORDER_OBSOLETE'))&&$_smarty_tpl->tpl_vars['rs']->value['is_insure']==1){?>
                    <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['insure_price'];?>
：
                        <?php echo $_smarty_tpl->tpl_vars['rs']->value['dml_insure_price'];?>

                    </li>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['express_calculation']==1){?>
                <li><?php echo $_smarty_tpl->tpl_vars['lang']->value['volume_weight_detail'];?>
：
                    <?php echo $_smarty_tpl->tpl_vars['rs']->value['dml_volume_weight'];?>

                </li>
                <?php }?>
			</ul>
		</div>
		</td>
	</tr>   
	<tr><th><?php echo $_smarty_tpl->tpl_vars['lang']->value['sale_order_info'];?>
</th></tr>   
	<tr><td><?php echo $_smarty_tpl->getSubTemplate ("SaleOrder/detail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</td></tr>
    <?php if (!in_array($_smarty_tpl->tpl_vars['login_user']->value['role_id'],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))){?>
	<tr><td valign="top" class="b_top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="add_table_money">
			<tr id="sale_funds_after">
				<td class="b_top t_right" ><?php echo $_smarty_tpl->tpl_vars['lang']->value['expected_delivery_costs'];?>
：</td>
				<td class="b_top t_right_red" width="100"><?php echo $_smarty_tpl->tpl_vars['rs']->value['expected_delivery_costs'];?>
</td>
			</tr> 
		</table>
	</td></tr>
    <?php }?>
	<tr><th><?php echo $_smarty_tpl->tpl_vars['lang']->value['client_info'];?>
</th></tr> 
	<tr><td>
		<table width="80%" cellspacing="0" cellpadding="0" border="0">
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
							<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
：</td>
							<td class="t_left"><?php echo $_smarty_tpl->tpl_vars['rs']->value['comments'];?>
</td>
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
<?php }} ?>