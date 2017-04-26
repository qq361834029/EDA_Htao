{wz is_update=0}

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
				<li>{$lang.orderno}：    {$rs.order_no}</li>
				<li>{$lang.order_date}： {$rs.fmd_order_date}</li> 
				<li>{$lang.express_way}：{$rs.ship_name}</li>
				<li>{$lang.track_no}：	 {$rs.track_no}</li>
				<li>{$lang.package}：	 {$rs.package_name}</li>
				<li>{$lang.total_weight}：{$rs.detail_total.s_unit_weight}</li>
			</ul>
		</div>
		</td>
	</tr>   
	<tr><th>{$lang.sale_order_info}</th></tr>   
	<tr><td>{include file="SaleOrder/outStockDetail.tpl"}</td></tr>
	<tr><td>&nbsp;</td></tr>   
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