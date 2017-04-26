{if $smarty.get.sent_email}
	{assign var='from' value=$m_item.sale_order_detail}
{else}
	<script>
	$(document).ready(function(){
	    $('.detail_list').css('width','95%');
	    $('.tablediv').css('max-height','');
	});
	</script>
	{assign var='from' value=$list}
{/if}
{detail_table flow='sale' from=$from.list action=['view'] op_show=['add','edit'] viewaction=['view','getClientStatSaleDetail','sentEmailDetail'] barcode=false
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.price,'flow_mantissa','flow_multi_storage',$lang.total_money,'flow_sale_discount','flow_sale_after_discount']}
<tr index="{$index}" class="{$none}" >
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
	{td id="span_product"  view="product_no" width="115" class="t_left"}
		<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w80">
		<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/ProductSale'|U}" jqac class="w80">
	{/td}
	{td id="span_product_name" view="product_name"  class="t_left"}
	{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="66" }
		<input type="hidden" name="detail[{$index}][color_id]" value="{$item.color_id}" {if C('STORAGE_COLOR')==1} onchange="$.getProductInfoById(this);" {/if}>
		<input type="text" name="color_name" value="{$item.color_name}" url="{'AutoComplete/color'|U}" jqac>
	{/td}
	{td type="flow_size" view="size_name" width="66"}
		<input type="hidden" name="detail[{$index}][size_id]" value="{$item.size_id}" {if C('STORAGE_SIZE')==1} onchange="$.getProductInfoById(this);" {/if}>
		<input type="text" name="size_name" value="{$item.size_name}" url="{'AutoComplete/size'|U}" jqac>
	{/td}
	{td type="flow_quantity" view="dml_quantity" width="90" tfoot=[total_quantity=>""]  tfoot_value="{$from.total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" class="w50" id="quantity" value="{$item.edml_quantity}" row_total>
	{/td}
	{td type="flow_capability" view="dml_capability" width="90" class="t_right"}
		<input type="text" name="detail[{$index}][capability]" class="w50" id="capability" value="{$item.edml_capability}" row_total>
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="90" class="t_right"}
		<input type="text" name="detail[{$index}][dozen]" class="w50" value="{$item.edml_dozen}" row_total>
	{/td}
	{td width="150" type="flow_row_total" view="dml_sum_quantity" tfoot=[total_col_qn=>""] tfoot_value="{$from.total.dml_sum_quantity}"  total_row_qn="" class="t_right"}
		{$item.edml_sum_quantity}
	{/td}
	{td view="dml_price" width="90" class="t_right"}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" row_total_money  class="w50">
	{/td}
	{td type="flow_mantissa" view="dd_mantissa" width="40" }
		<input type="hidden" value="{$item.mantissa|default:1}" name="detail[{$index}][mantissa]" id="mantissa">
		<input type="checkbox" type="checkbox" onclick="$.setQuantityState(this);$.getLastQuantity(this);" {if $item.mantissa==2}checked{/if}>
	{/td}
	{td type="flow_multi_storage" view='w_name' width="66" class="t_left"}
		{warehouse   hidden=["name"=>"detail[$index][warehouse_id]",'value'=>$item.warehouse_id] value=$item.w_name  name="warehouse_name"  }
	{/td}
	{td id="sum_money" class="t_right" tfoot=[total_col_money=>""] total_row_money="" tfoot_value="{$from.total.dml_money}" class="t_right"}
		{$item.edml_money}
	{/td} 
	{td view="dml_discount" width="90" type="flow_sale_discount" class="t_right"}	
		<input type="text" name="detail[{$index}][discount]" id="discount" class="w40" value="{$item.edml_discount}" row_total_disount>%
	{/td}
	{td  width="121" class="t_right" view="dml_discount_money" type="flow_sale_after_discount" tfoot_id="total_after_discount_money" total_row_dis_money="" tfoot_value="{$from.total.dml_discount_money}" tfoot=[total_col_dis_money=>""]}
		{$item.dml_discount_money}
	{/td}
	{detail_operation}
</tr>
{/detail_table}
<table class="detail_list" cellspacing="0" cellpadding="0" style="width:100%">
    <tfoot>
    <tr class="red">
        <td style="text-align:right">{$lang.preferential_money}：{$from.main.dml_pr_money} &nbsp;&nbsp;&nbsp;&nbsp;
            {$lang.total_account_money}：{$from.main.dml_account_money}</td>
    </tr>
    </tfoot>
</table>