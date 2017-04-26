{detail_table thead=[$lang.product_no,$lang.product_name] op_show=['add','edit'] from=$rs.detail barcode=false}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td width="14%"}
		<input type="hidden" name="detail[{$index}][product_id]" jqproc value="{$item.product_id}">
		<input type="text" name="conn_product_no[{$index}]" url="{'AutoComplete/product'|U}" jqac value="{$item.product_no}" class="w120"/>
	{/td}
	<td id="span_product_name" class="t_left">
		{$item.product_name}
	</td>
	{detail_operation}
</tr>
{/detail_table}