{wz is_update=$rs.is_update}
{*wz*}
<div class="add_box" style="border: 1px solid #89A5C5;">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody> 
		<tr>
		<th>
			<div class="titleth">
				<div class="titlefl">{$lang.basic_info}</div>
				<div class="afr">{$lang.deal_no}：{$rs.sale_order_no}</div>
			</div>
		</th>
		</tr>
	<tr><td>
		<div class="basic_tb">
			<ul>  
				<li>{$lang.orderno}：   {$rs.order_no}</li>
				<li>{$lang.clientname}：{$rs.client_name}</li>
				<li>{$lang.sale_date}： {$rs.fmd_order_date}</li>
				<li>{$lang.order_type}：{$rs.order_type_name}</li>
                {if $rs.order_type == C('ALIEXPRESS')}
                <li>
                    {$lang.aliexpress_token}：{$rs.aliexpress_token}
                </li>
                {/if}
				<li>{$lang.shipping_warehouse}：{$rs.w_name}</li> 
				<li>{$lang.express_way}：       {$rs.ship_name}</li>				
				<li>{$lang.express_date}：	{$rs.ship_date}</li>
				{if $rs.company_id== C('EXPRESS_BRT_ID') && $rs.warehouse_id== C('EXPRESS_IT_WAREHOUSE_ID')}
				<li>{$lang.brt_account_no}：       {$rs.brt_account_no}</li>
				{/if}
				<li>{$lang.is_registered}：	{$rs.dd_is_registered}</li>
				<li>{$lang.track_no}：		{$rs.track_no}</li>
				{if $rs.package_id}
				<li>{$lang.package}：	{$rs.package_name}</li>
				{/if}				
				<li>{$lang.sale_order_state}：{$rs.dd_sale_order_state}</li>
                                {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
                                <li>{$lang.belongs_seller}：{$rs.factory_name}</li>  
                                {/if}         
                {if $rs.fmd_send_date}
                <li>{$lang.out_stock_date}:{$rs.fmd_send_date}</li>
                {if $admin && $rs.ship_cost_id > 0}
                <li>{$lang.shipping_cost_name}:{$rs.ship_cost_name}</li>
                {/if}
                {/if}
                {if $rs.return_id}
                	<li>{$lang.return_sale_order_no}:<a href="javascript:;" onclick="addTab('{"/ReturnSaleOrder/view/id/{$rs.return_id}"|U}','{"viewReturnOrder"|L}',1)">{$rs.return_no}</a></li>
                {/if}
                <li>{$lang.insure}：
                    {$rs.dd_is_insure}
                </li>
                {if ($rs.is_out || $rs.sale_order_state==C('SALEORDER_OBSOLETE')) && $rs.is_insure==1}
                    <li>{$lang.insure_price}：
                        {$rs.dml_insure_price}
                    </li>
                {/if}
                {if $rs.express_calculation==1}
                <li>{$lang.volume_weight_detail}：
                    {$rs.dml_volume_weight}
                </li>
                {/if}
			</ul>
		</div>
		</td>
	</tr>   
	<tr><th>{$lang.sale_order_info}</th></tr>   
	<tr><td>{include file="SaleOrder/detail.tpl"}</td></tr>
    {if !in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))}
	<tr><td valign="top" class="b_top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="add_table_money">
			<tr id="sale_funds_after">
				<td class="b_top t_right" >{$lang.expected_delivery_costs}：</td>
				<td class="b_top t_right_red" width="100">{$rs.expected_delivery_costs}</td>
			</tr> 
		</table>
	</td></tr>
    {/if}
	<tr><th>{$lang.client_info}</th></tr> 
	<tr><td>
		<table width="80%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						

						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left">{$rs.consignee}</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left">{$rs.transmit_name}</td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
								{$rs.country_name} {$rs.abbr_district_name} 
							</td>
						</tr>
						<tr>
							<td>{$lang.belongs_city}：</td>
							<td class="t_left">
								{$rs.city_name}
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left">{$rs.email}</td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left">{$rs.tax_no}</td>
						</tr>
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left">{$rs.edit_address}</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left">{$rs.edit_address2}</td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left">{$rs.company_name}</td>
						</tr>
						
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left">{$rs.post_code}</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left">{$rs.mobile}</td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left">{$rs.fax}</td>
						</tr>
						{if $rs.gallery}
						<tr>
							<td>{$lang.download_file}：</td>  
                            <td class="t_left">
                                {foreach $rs.gallery as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                    </div>
                                {/foreach}
                            </td>                  
						</tr>
						{/if}
					</tbody>
				</table>
				</td>
				
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td>{$lang.comments}：</td>
							<td class="t_left">{$rs.comments}</td>
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
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
</div> 
