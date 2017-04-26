{detail_table flow='instock' from=$rs.detail action=['view','edit'] op_show=['add','edit'] barcode=false
	thead=[$lang.factory_name,'flow_factory_currency',$lang.product_no,$lang.product_name,'flow_config','flow_per_size','flow_per_capability','flow_mantissa','flow_instock_price_show','flow_show_instock_logistics_funds','flow_instock_total_money']}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][delivery_fee_detail]" value="{$item.delivery_fee_detail}">
	{td view="factory_name" width="10%" class="t_left" viewstate=['fund_state'=>[1]]}
		<input type="hidden" name="detail[{$index}][factory_id]"  class="w120" value="{$item.factory_id}" onchange="getFacCurrencyId(this,2);">
		<input type="text" name="temp[factory_name]" url="{'AutoComplete/factory'|U}" jqac value="{$item.factory_name}" class="w120 t_left" />
	{/td}
	{td type="flow_factory_currency" view="currency_no" width="6%" viewstate=['fund_state'=>[1]]}
		{if $item.fund_state==1}
			<input type="hidden" name="detail[{$index}][currency_id]" value="{$item.currency_id}">
			<input type="text" name="currency_name" value="{$item.currency_no}" class="t_left" >
		{else}
			{currency data=C('factory_currency') name="detail[{$index}][currency_id]" value=$item.currency_id id="currency_id" class="t_left"}
		{/if}
	{/td}
	{td id="span_product" class="t_left" view="product_no" width="8%" tfoot_value=$rs.detail_total.total_product viewstate=['fund_state'=>[1]]}
		<input type="hidden" name="detail[{$index}][product_id]" value="{$item.product_id}" onchange="{if C('product_color')==1}$.colorEnabled(this);{/if}{if C('product_size')==1}$.sizeEnabled(this);{/if} " jqproc>
		
		<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" {if $rs}where="{"factory_id={$item.factory_id}"|urlencode}"  class="w100 t_left"jqac {else}disabled class="disabled w100 t_left"{/if}>
		
	{/td}
	<td id="span_product_name"  width="12%" class="t_left">
		{$item.product_name}
	</td>
	{td type="flow_color" view="color_name" width="6%" viewstate=['fund_state'=>[1]]}
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}">
		<input type="text" name="color_name" class="t_left" value="{$item.color_name}" url="{'AutoComplete/color'|U}" {if C('product_color')==1 && $rs}where="{"id in(select color_id from product_color where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_color')==1}disabled class="disabled"{elseif C('PRODUCT_FACTORY')!=10}jqac{/if} {$readonly}>
	{/td}
	{td type="flow_size" view="size_name" width="6%" viewstate=['fund_state'=>[1]]}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}">
		<input type="text" name="size_name"  class="t_left"  value="{$item.size_name}" url="{'AutoComplete/size'|U}" {if C('product_size')==1 && $rs}where="{"id in(select size_id from product_size where product_id={$item.product_id})"|urlencode}" jqac {elseif C('product_size')==1}disabled class="disabled"{elseif C('PRODUCT_FACTORY')!=1}jqac{/if} {$readonly}>
	{/td}
	{td type="flow_quantity" class="t_right" view="dml_quantity"  tfoot=[total_quantity=>""]  width="6%" tfoot_value=$rs.detail_total.quantity viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][quantity]" value="{$item.edml_quantity|intval}"  row_total {$readonly}>
	{/td}
	{td type="flow_capability" view="dml_capability" width="5%" class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][capability]" value="{$item.edml_capability}" row_total {$readonly}>
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="5%" class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][dozen]"  value="{$item.edml_dozen}" row_total {$readonly}>
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" width="8%" total_row_qn="" tfoot=['total_col_qn'=>''] tfoot_value=$rs.detail_total.sum_quantity class="t_right"}
		{$item.dml_sum_quantity}
	{/td}
	{td type='flow_per_size' view='dml_per_size'  tfoot=[col_per_size=>""] width="5%" class="t_right" tfoot_value=$rs.detail_total.dml_real_per_szie viewstate=['fund_state'=>[1]]}
	{if $rs.funds.logistics}
		<input type="text" name="detail[{$index}][per_size]" value="{$item.edml_per_size}" row_per readonly class="disabled">
	{else}
		<input type="text" name="detail[{$index}][per_size]" value="{$item.edml_per_size}" row_per {$readonly}>
	{/if}
	{/td}
	{td type="flow_per_capability" view='dml_per_capability' tfoot=[col_per_capability=>""] width="6%" class="t_right" tfoot_value=$rs.detail_total.dml_real_per_capability viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][per_capability]" value="{$item.edml_per_capability}" row_per {$readonly}>
	{/td}
	{td type="flow_mantissa" view="dd_mantissa"  width="3%" viewstate=['fund_state'=>[1]]}
		<input type="hidden" name="detail[{$index}][mantissa]" value="{$item.mantissa|default:1}"/>
		<input id="quantity_state" type="checkbox"  {if $item.mantissa==2}checked{/if} onclick="$.setQuantityState(this);" {if $item.fund_state==1}disabled{/if}>	
	{/td}
	{td view="dml_price" width="6%" type='flow_instock_price_show' class="t_right" viewstate=['fund_state'=>[1]]}
		<input type="text" name="detail[{$index}][price]" value="{$item.edml_price}" row_total_money {$readonly}>
	{/td}
	{td view='dml_delivery_fee_detail' type='flow_show_instock_logistics_funds' class="t_right" width="8%"}
	 	{$item.dml_delivery_fee_detail}
	{/td}
	{td id="total_money" type="flow_instock_total_money" total_row_money="" tfoot=['total_col_money'=>''] tfoot_value=$rs.detail_total.dml_money class="t_right"}
		{$item.dml_money}
	{/td}
	{detail_operation viewstate=['fund_state'=>[1]]}
</tr>
{/detail_table}
