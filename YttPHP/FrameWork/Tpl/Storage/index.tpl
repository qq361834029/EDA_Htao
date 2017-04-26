{wz}
<form method="POST" action="{"Storage/index"|U}" id="search_form">
<input type="hidden" id="rand" name="rand" value="{$rand}">	
__SEARCH_START__
<dl>
	{if !$is_warehouser}
	<dt>
		<label>{$lang.warehouse_name}：</label>
        <input type="hidden" id="warehouse_id" name="query[warehouse_id]" onchange="setLocationWhere();" >
		<input type="text" id="w_name" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" where="is_return_sold=1" jqac /> 
	</dt>
    {else}
    <dt style="display: none;">
		<label>{$lang.warehouse_name}：</label>
		<input type="hidden" id="warehouse_id" name="query[warehouse_id]" onchange="setLocationWhere();" >
		<input type="text" id="w_name" name="temp[w_name]" where='relation_warehouse_id={$login_user.company_id}' url="{'AutoComplete/relationReturnWarehouse'|U}" jqac /> 
	</dt>
	{/if}	
	{if !$is_factory}
	<dt>
		<label>{$lang.belongs_seller}：</label>
		<input type="hidden" name="query[p.factory_id]">
		<input type="text" name="factory_email" url="{'AutoComplete/factoryEmail'|U}" jqac />
	</dt>
	{/if}	
	<dt>
		<label>{$lang.product_id}：</label>
		<input type='text' name="query[a.product_id]" class="spc_input" value="{$smarty.post.query.a.product_id}">
	</dt>	
	<dt>
		<label>{$lang.product_no}：</label>
		<input type='text' name="like[p.product_no]" class="spc_input">
	</dt>
    <dt>
        <label>{$lang.is_return_sold}：</label>
    {if !$is_warehouser}
        {radio data=C('IS_RETURN_SOLD') value=1 onclick="SetWarehouseLocation(this);" name="query[w.is_return_sold]"}
    {else}
        {radio data=C('IS_RETURN_SOLD') value=1 onclick="showWarehouse(this);SetWarehouseLocation(this);" name="query[w.is_return_sold]"}
    {/if}
    </dt>
    <dt>
        <label>{$lang.warehouse_location}：</label>
        <input type="hidden" id='location_id' name="query[location_id]" />
        <input type="text" id='location_no' name="temp[location_no]" url="{'AutoComplete/warehouseListLocationNo'|U}" where="w.is_return_sold=1" jqac /> 
    </dt>
	<dt>
		<label>{$lang.custom_barcode}：</label>
		<input type='text' name="like[p.custom_barcode]" url="{'/AutoComplete/productCustomBarcode'|U}" jqac>
	</dt>
    <dt>
		<label>{$lang.max_inventory_quantity}：</label>
		<input type='text' name="max_sale_quantity" class="spc_input">
	</dt>
</dl>	
<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note export=true accord_location_export=true accord_sku_export=true accord_fifo_export=true}
<div id="print" class="width98">
{include file="Storage/list.tpl"}
</div>