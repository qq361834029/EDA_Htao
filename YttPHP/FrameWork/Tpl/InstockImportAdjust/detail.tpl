{if $smarty.const.ACTION_NAME == 'view'}
	{assign var="thead" value=[$lang.box_id,$lang.product_id,$lang.product_no,$lang.location_no,$lang.quantity,$lang.common_adjust_total,$lang.old_in_quantity]}
{else}
	{assign var="thead" value=[$lang.box_id,$lang.product_id,$lang.product_no,$lang.location_no,$lang.quantity,$lang.old_in_quantity,$lang.common_adjust_total]}
{/if}
{detail_table flow='instock_import_adjust' from=$rs.detail action=['view','edit'] op_show=['add','edit']
	warehouse=true
	thead=$thead}
<tr index="{$index}" class="{$none}" class="t_left">
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	<input type="hidden" name="detail[{$index}][instock_detail_id]" value="{$item.instock_detail_id}" id="instock_detail_id">
	<input type="hidden" name="detail[{$index}][warehouse_id]" value="{$rs.warehouse_id}" id="warehouse_id">
	<input type="hidden" name="detail[{$index}][origin_number]" id="origin_quantity" value="{$item.edml_quantity}" >
	<input type="hidden" name="detail[{$index}][original_in_number]" id="original_in_number" value="{$item.in_quantity}">

	{td type="box_id" id="span_box_id" view="box_id" width="" width="56" class="t_left"}
		<input type="hidden" id="box_id" name="detail[{$index}][box_id]" value="{$item.box_id}" onchange="setProductWhere(this);">
		<input type="text"   name="temp[{$index}][id]" value="{$item.box_id}" url="{'AutoComplete/boxId'|U}" class="box_id w100 {if !$rs.instock_id} disabled{/if}"  {if !$rs.instock_id}	 disabled="disabled"{else} where="{"instock_id='`$rs.instock_id`'"}"  {/if} jqac >
	{/td}
	
	{td  id="span_product_id" view="product_id"  width="56" class="t_left"}
		<input type="hidden" id="product_id" name="detail[{$index}][product_id]" value="{$item.product_id}" jqproductid>
		<input type="text"   name="temp[{$index}][product_id]" value="{$item.product_id}" url="{'AutoComplete/instockProductId2'|U}" class="product_id w100 {if !$item.product_id} disabled{/if}"  {if !$item.product_id}  disabled="disabled"{else} where="{"instock_id='`$rs.instock_id`' and box_id='`$item.box_id`'"|urlencode}"  {/if} jqac>
	{/td}

	{td id="span_product_no" class="t_left" view="product_no" width="320" }
		<span id="product_no">{$item.product_no}</span>
	{/td}

	{td id="span_barcode_no" class="t_left" view="barcode_no" width="320"}
		<input type="hidden" name="detail[{$index}][location_id]" id="location_id" value="{$item.location_id}" onchange="getWarehouseIdById(this);return false;"  class="w200">
		<input type="text" name="temp[{$index}][barcode_no]" id="barcode_no" value="{$item.barcode_no}"  url="{'AutoComplete/adjustLocationNo'|U}"  {if $item.instock_detail_id}  where="{"warehouse_id='`$rs.warehouse_id`'"|urlencode}" {/if} jqac class="w200" >
	{/td}

	{td id="span_origin_quantity"  class="t_right"  view="dml_quantity"  width="56"  }
		{$item.edml_quantity}
	{/td}
	
	{if $smarty.const.ACTION_NAME == 'view'}
		{td type="flow_quantity" view="adjust_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_adjust_quantity}" tfoot_id="total_adjust_quantity" class="t_right"}
			<input type="text" name="detail[{$index}][quantity]" class="w100" id="quantity" value="{$item.edml_adjust_quantity}" row_total {$readonly}>
		{/td}
		
		{td id="span_in_quantity" class="t_right" view="in_quantity" width="10%" }
			{$item.edml_in_quantity}
		{/td}
	{else}
		{td id="span_in_quantity" class="t_right" view="in_quantity" width="10%" }
			{$item.edml_in_quantity}
		{/td}

		{td type="flow_quantity" view="adjust_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_adjust_quantity}" tfoot_id="total_adjust_quantity" class="t_right"}
			<input type="text" name="detail[{$index}][quantity]" class="w100" id="quantity" value="{$item.edml_adjust_quantity}" row_total {$readonly}>
		{/td}
	{/if}
	
	{detail_operation}
</tr>
{/detail_table}