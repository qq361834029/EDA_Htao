{if $smarty.const.ACTION_NAME  neq 'view'}
{assign var="action" value=['add','edit']}
{else}
{assign var="action" value=['add']}
{/if}
{detail_table flow='instock_storage' from=$rs.product op_show=$action
	thead=[$lang.serial_id,$lang.box_id,$lang.box_no,$lang.product_id,$lang.product_no,$lang.product_name,$lang.quantity,$lang.accepting_quantity,$lang.old_in_quantity,$lang.new_storage_quantity,$lang.warehouse_location]}
<tr index="{$index}" class="{$none}">
	<td class="t_left w60">
    <input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
    <input type="hidden" name="detail[{$index}][warehouse_id]" value="{$item.warehouse_id}">
    <input type="hidden" name="detail[{$index}][instock_detail_id]" value="{$item.instock_detail_id}">
    <input type="hidden" name="detail[{$index}][old_quantity]"  value="{$item.new_quantity}">
        {if $index > 0}{$index}{/if}
	</td>
	<td class="t_left w60">
		{$item.box_id}
	</td>
	<td class="t_left w60">
		{$item.box_no}
	</td>
	<td class="t_left w60">
    <input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" />
    {$item.product_id}
	</td>
	<td class="t_left w180">
		{$item.product_no}
	</td>
	<td class="t_left w60">
		{$item.product_name}
	</td>
	{td class="t_right" width="10%" tfoot_value=$rs.all_product_quantity }
        {$item.edml_quantity}
	{/td}
	{td class="t_right" width="10%" tfoot_value=$rs.all_accepting_quantity }
        {$item.dml_accepting_quantity}
	{/td}
	{td class="t_right" width="10%" tfoot_value=$rs.all_in_quantity}
        {$item.dml_in_quantity}
	{/td}
	{td class="t_right" view="new_quantity" width="10%" tfoot_value=$rs.this_in_quantity }
		<input type="text" name="detail[{$index}][in_quantity]" value="{$item.new_quantity}"  class="w120">
	{/td}
	{td id="span_location_no" class="t_left" view="location_no" width="240" tfoot_id="total_barcode_no" tfoot_value="{$rs.detail_total.total_produc}"}
	<input type="hidden" name="detail[{$index}][location_id]" id="location_id" value="{$item.location_id}" class="w200">
	<input type="text" name="temp[{$index}][location_no]" value="{$item.location_no}" url="{'AutoComplete/locationNo'|U}" where ="warehouse_id={$rs.warehouse_id}" jqac class="w200" {$readonly}>
	{/td}    
    {detail_operation
		span=[
			['class'=>'icon icon-add-plus','onclick'=>'$.copyRowWithoutClear(this)','title'=>$lang.copy],
			['class'=>'icon icon-del-plus','onclick'=>'$.delRow(this,0);','title'=>$lang.delete,'tfoot'=>false]
		]
    }
</tr>
{/detail_table}