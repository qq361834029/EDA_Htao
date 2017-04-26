{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
{assign var="action" value=['add','edit']}
{assign var="deal_state" value=['instock_type'=>[2,3,4,5,6,7,8,9,10,11,12]]}
{assign var='pass' value='false'}
{else}
{assign var="action" value=['add']}
{assign var="deal_state" value=['instock_type'=>[1,2,3,4,5,6,7,8,9,10,11,12]]}
{assign var='pass' value='true'}
{/if}
{detail_table flow='instock' from=$rs.product action=['view'] op_show=$action
	thead=['flow_serial_id_config','flow_box_id_config',$lang.box_no,'flow_product_id_config',$lang.product_no,$lang.custom_barcode,$lang.product_name,$lang.check_weight_with_unit,$lang.check_spec_detail,$lang.declared_value,$lang.quantity,$lang.accepting_quantity,'flow_instock_in_quantity','flow_instock_diff_quantity']}
<tr index="{$index}" class="{$none}">
{if $tpl_module_name == 'view' || $smarty.const.ACTION_NAME == 'view'}
	<td class="t_left w60">
        {if $index > 0}{$index}{/if}
	</td>
	<td class="t_left w60">
        {$item.box_id}
	</td>
	<td id="span_box" class="t_left w120">
		{$item.box_no}
	</td>
	<td class="t_left w60">
		{$item.product_id}
	</td>
	<td id="span_product" class="t_left w120">
		{$item.product_no}
	</td>
{else}
	{td id="span_box" class="t_left w120" view="box_no"  viewstate=$deal_state}
		<input type="hidden" name="product[{$index}][id]" value="{$item.id}">
		<input type="hidden" name="product[{$index}][box_id]" value="{$item.box_id}" jqproc>
		<input type="text" name="temp[{$index}][box_no]" value="{$item.box_no}" url="{'AutoComplete/instockBoxNo'|U}" where="{" instock_id = '{$rs.id}' "|urlencode}" class="w120 t_left" jqac>
	{/td}
	{td id="span_product" class="t_left w120" view="product_no"  viewstate=$deal_state}
		<input type="hidden" name="product[{$index}][product_id]" value="{$item.product_id}" jqproc>
		<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" where="{" factory_id='{$rs.factory_id}' "|urlencode}" class="w120 t_left" jqac>
	{/td}
{/if}
	<td id="span_custom_barcode" class="t_left">
		{$item.custom_barcode}
	</td>
	<td id="span_product_name" class="t_left w80">
		{$item.product_name}
	</td>
{if $tpl_module_name == 'view' || $smarty.const.ACTION_NAME == 'view'}
    {td id="span_check_weight" class="t_left w80"  tfoot=[total_check_weight=>""] tfoot_value=$rs.product_total.dml_check_weight }
		{$item.dml_check_weight}       
	{/td}
    {td id="span_check_cube" class="t_left" tfoot=[total_check_cube=>""] tfoot_value=$rs.product_total.dml_check_cube}
		{$item.s_check_cube}
	{/td}
	<td class="t_left w60">
		{$item.declared_value}
	</td>
{else}
    <td id="span_check_weight" class="t_left w80">{$item.dml_check_weight} </td>
    <td id="span_check_cube" class="t_left">{$item.s_check_cube}</td>
    
	{td class="t_right" view="declared_value"  width="8%"  viewstate=$deal_state}
		<input type="text" id="span_declared_value" name="product[{$index}][declared_value]" value="{$item.declared_value}"  class="w120" row_total {$readonly}>
	{/td}
{/if}
	{td class="t_right" view="dml_quantity"  tfoot=[total_quantity=>""]  width="8%" tfoot_value=$rs.product_total.dml_quantity  viewstate=$deal_state}
	<input type="text" name="product[{$index}][quantity]" value="{$item.edml_quantity}"  class="w120" row_total {$readonly}>
	{/td}
	{td   class="t_right" id="total_accepting_quantity" view="dml_accepting_quantity"  tfoot=[total_accepting_quantity=>""]  width="8%" tfoot_id="total_accepting_quantity"  tfoot_value=$rs.product_total.dml_accepting_quantity}
	 {$item.edml_accepting_quantity}
	{/td}
	{td type="flow_instock_in_quantity" class="t_right" view="dml_in_quantity"  tfoot=[total_quantity=>""]  width="8%" tfoot_value=$rs.product_total.dml_in_quantity}
		{$item.dml_in_quantity}
	{/td}
	{if $item.diff_quantity < 0}
		{assign var=diff_quantity_color value="red"}
	{else}
		{assign var=diff_quantity_color value=""}
	{/if}
	{td type="flow_instock_diff_quantity" class="t_right $diff_quantity_color" view="dml_diff_quantity"  tfoot=[total_diff_quantity=>""]  width="8%" tfoot_value=$rs.product_total.dml_diff_quantity}
		{$item.dml_diff_quantity}
	{/td}
{if $tpl_module_name != 'view' && $smarty.const.ACTION_NAME != 'view'}
	{detail_operation  viewstate=$deal_state}
{/if}
</tr>
{/detail_table}