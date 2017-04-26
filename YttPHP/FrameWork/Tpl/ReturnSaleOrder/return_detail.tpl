{if $smarty.const.ACTION_NAME=='view'}
    {assign var='service_action' value='view'}
{elseif $smarty.get.id}
	{assign var='service_action' value='edit'}
{else}
    {assign var='service_action' value='add'}
{/if}
{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
{assign var="action" value=['view','edit']}
{assign var="deal_state" value=['return_sale_order_state'=>[2,3,4,5,6,7,8,10]]}
{else}
{assign var="action" value=['add']}
{assign var="deal_state" value=['return_sale_order_state'=>[1,2,3,4,5,6,7,8,9]]}
{/if}
{if $smarty.const.ACTION_NAME=="edit" || $tpl_action_name=="edit"}
        {assign var=edit_qn     value=1}
    {if $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER')}
        {assign var=edit_sku    value=1}
    {else}
        {if in_array($rs.return_sale_order_state,C('CAN_EDIT_SERVICE'))}
            {assign var=edit_sku    value=0}
            {assign var=edit_qn     value=0}
        {else}
            {assign var=edit_sku    value=1}
        {/if}
    {/if}
{else}
    {if $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER')}
        {assign var=edit_sku    value=1}
    {else}
        {assign var=edit_sku    value=0}
    {/if}
        {assign var=edit_qn     value=0}
{/if}
{if $tpl_action_name}
{assign var="op_action" value=$tpl_action_name}
{else}
{assign var="op_action" value={$smarty.const.ACTION_NAME}}
{/if}
	{assign var=op_show value=['add', 'edit']}
{if $rs and $rs.is_related_sale_order != C('IS_RELATED_SALE_ORDER')}
	{assign var=thead value=[$lang.product_id,$lang.product_no,$lang.custom_barcode,$lang.product_name,$lang.return_quantity,$lang.treatment]}
	{assign var="deal_state" value=['return_sale_order_state'=>[2,3,4,5,6,7,8,10]]}
{else}
	{assign var=thead value=[$lang.product_id,$lang.product_no,$lang.custom_barcode,$lang.product_name,'flow_quantity',$lang.return_quantity,$lang.treatment]}
{/if}
{detail_table flow='sale' from=$rs.detail action=$action op_show=$op_show 
	thead=$thead}
<tr index="{$index}" class="{$none}">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">    
    {td id="span_product_id" class="t_left" viewstate=$deal_state span_product="{$item.product_id}" view="product_id" width="100" }
        <input type="hidden" id="product_no" value="{$item.product_id}" jqpinfo flow="sale_return">
        <input type="text" id="product_id_show" name="detail[{$index}][product_id]" url="{'AutoComplete/productId'|U}" {if $rs.factory_id}where="{"factory_id={$rs.factory_id}"|urlencode}"{/if} {if $edit_sku}class="w100 disabled" readonly{else}  jqac class="w100"{/if} value="{$item.product_id}">
    {/td}
	{td id="span_product" class="t_left" viewstate=$deal_state span_product="{$item.product_id}" view="product_no" width="150"}
    <input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqpinfo  flow="sale_return">
		<input type="text" name="temp[{$index}][product_no]" id="product_no_show" url="{'AutoComplete/product'|U}" {if $rs.factory_id}where="{"factory_id={$rs.factory_id}"|urlencode}"{/if} {if $edit_sku}class="w100 disabled" readonly{else}  jqac class="w100"{/if} value="{$item.product_no}">
	{/td}
	<td id="span_custom_barcode" class="t_left">
		{$item.custom_barcode}
	</td>
	<td id="span_product_name" class="t_left">	         
		{$item.product_name}
	</td>
	{if !$rs or $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER')}
	{td id="total_row_qn" view="dml_sale_order_number"  tfoot=[total_return_quantity=>""]  width="80" tfoot_value=$rs.detail_total.dml_sale_order_number  class="t_right"}
		<input type="text" name="detail[{$index}][sale_order_number]" class="w80 disabled" readonly value="{$item.edml_sale_order_number}" row_return_total>
	{/td}
	{/if}
	{td id="span_quantity" span_quantity="{$item.edml_quantity}" viewstate=$deal_state type="flow_quantity" view="edml_quantity" tfoot=['total_col_qn'=>''] width="80" tfoot_value=$rs.detail_total.dml_quantity class="t_right"}
    	<input onchange="updateRetuenService(this);" type="text" id="quantity" name="detail[{$index}][quantity]" row_total value="{$item.edml_quantity}" {if $edit_qn}class="w80 disabled" readonly{else}  class="w80"{/if} {$readonly}>
	{/td}
	{td viewstate=$deal_state type="treatment" view="treatment" width="50" } 	  
		<input type="hidden" id="return_service" name="detail[{$index}][return_service]" value='{$item.return_service}' {$readonly}>
		<input type="hidden" name="detail[{$index}][relation_id]" value="{$item.relation_id}">           	
		{if $item.no_show!='1'}		   
		   {if $item.return_service} 		      
		       <a  id="icon"  title="{L('treatment')}" style="cursor:pointer"  onclick="$.quicklyShowReturnService({$index}, this, '{$service_action}', '1');"><font id='ft' color="red">{$item.return_service_no}</font></a>
		   {else}		      
		       <a id="icon" class="icon icon-help"   title="{L('treatment')}" style="cursor:pointer"  onclick="$.quicklyShowReturnService({$index}, this, '{$service_action}', '1');"><font id='ft' color="red"></font></a>	  
		   {/if}		 	  
		{/if}
	{/td}
	{detail_operation}
</tr>
{/detail_table}