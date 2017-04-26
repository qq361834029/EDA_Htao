{assign var="action"       value=['edit']}
{assign var="deal_state"   value=['sale_order_state'=>C('SALE_ORDER_OUT_DETAIL_VIEW_STATE')]}
{assign var="detail_state" value=['state'=>[4]]} 

{if $verifyType=='1'}
{assign var="flow" value='verify'}
{else}
{assign var="flow" value='sale'}
{/if}

{if $rs.out_stock_type>1}
{assign var="addClass" value='tr_background-color-out_stock'}
{else}
{assign var="addClass" value=''}
{/if}

{detail_table tfoot=false flow=$flow from=$rs.detail action=['view'] op_show=$action barcode=true
	thead=[$lang.product_id,$lang.product_no,$lang.custom_barcode,$lang.product_name,$lang.sale_quantity,$lang.number_of_scans,'verify_quantity']}

	<tr index="{$index}" class="{$none} {$addClass}" >
		<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
		{td view="product_id" width="120" class="t_left"}
		{$item.product_id}
		{/td}

		{td viewstate=$deal_state id="span_product" view="product_no" width="320" class="t_left"}
			<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w320">
			<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" class="w320" {$readonly}>
		{/td}
		{td id="span_custom_barcode" view="product_name" width="320" class="t_left"}
		{$item.custom_barcode}
		{/td}
		{td id="span_product_name" view="product_name" width="320" class="t_left"}
		{$item.product_name}
		{/td}

		{td viewstate=$deal_state type="flow_quantity" view="dml_quantity" width="100" class="t_left"}
			<input type="text" name="detail[{$index}][quantity]" class="w80" id="quantity" value="{$item.edml_quantity}" {$readonly}>
		{/td}

		{td viewstate=$detail_state type="flow_real_quantity" view="dml_real_quantity" width="250" class="t_left"}
			<input type="text" name="detail[{$index}][real_quantity]" class="w80" id="real_quantity" value="{if $item.dml_real_quantity>0}{$item.edml_real_quantity}{/if}" {$readonly}>
		{/td}
		
		{td type="verify_quantity" id="span_verify_quantity" view="verify_quantity" width="250" class="t_left"}
			<input type="text" class="w80" id="verify_quantity" value="" name="detail[{$index}][verify_quantity]">
		{/td}
	</tr>

{/detail_table}
