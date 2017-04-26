{detail_table flow='order' from=$list tfoot=false tbody_empty=true barcode=false
	thead=[$lang.order_no,$lang.factory_name,$lang.product_no,'flow_color','flow_size','flow_quantity','flow_row_total','flow_unload_quantity',$lang.unload_qn,$lang.operation]}
<tr index="{$index}" class="{$none}" order_id="{$item.id}">
	<td>{$item.order_no}</td>
	<td>{$item.factory_name}</td>
	<td>{$item.product_no}</td>
	{td type="flow_color" view="color_name"} 
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_name"} 
		{$item.size_name}
	{/td}
	{td type="flow_quantity"}
		{$item.dml_sum_quantity}
	{/td}
	{td type="flow_row_total"}
		{$item.dml_sum_capability}
	{/td}
	{td type="flow_unload_quantity"}
		{$item.dml_load_capability}
	{/td}
	<td>{$item.dml_load_quantity}</td>
	<td>
		<a onclick="load('{$item.detial_id}',0,this);" href="javascript:;">装柜</a>
		<a onclick="load(0,'{$item.id}',this);" href="javascript:;">整单装柜</a>
	</td>
</tr>
{/detail_table}
