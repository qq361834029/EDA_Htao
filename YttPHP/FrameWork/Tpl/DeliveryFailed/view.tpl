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
			</ul>
		</div>
		</td>
	</tr>   
	<tr><th>{$lang.sale_order_info}</th></tr>   
	<tr><td>{include file="SaleOrder/outStockDetail.tpl"}</td></tr>
	<tr><td>&nbsp;</td></tr>   
	<tr><th>{$lang.client_info}</th></tr> 
	<tr><td>
		<div class="basic_tb">
		<ul> 
			<li>{$lang.clientname}：    {$rs.client_name}</li>
			<li>{$lang.client_abbr}：   {$rs.merge_address}</li>
			<li></li><li></li>
			<li>{$lang.sum_quantity}：  {$rs.detail_total.dml_sum_quantity}</li>
			<li>{$lang.total_volume}：  {if $rs.detail_total.dml_cube>0}{$rs.detail_total.dml_cube}{C('VOLUME_SIZE_UNIT')}{/if}</li>
		</ul>
		</div>
	</td></tr>                      
   </tbody>          
</table> 
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
</div> 