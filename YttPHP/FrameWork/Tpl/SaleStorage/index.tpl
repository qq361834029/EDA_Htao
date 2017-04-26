{wz}
<form method="POST" action="{"SaleStorage/index"|U}" id="search_form">
__SEARCH_START__
<dl>
	<dt>
		<label>{$lang.product_no}：</label>
		<input type="hidden" name="query[a.product_id]">
		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=1}
	<dt>
		<label>{$lang.class_name_1}：</label>
		<input type="hidden" name="query[class_1]" value="{$smarty.post.query.class_1}">
		<input type='text' url="{'/AutoComplete/productClass'|U}" where="{"class_level=1"|urlencode}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=2}
	<dt>
		<label>{$lang.class_name_2}：</label>
		<input type="hidden" name="query[class_2]">
		<input type='text' url="{'/AutoComplete/productClass'|U}" where="{"class_level=2"|urlencode}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=3}
	<dt>
		<label>{$lang.class_name_3}：</label>
		<input type="hidden" name="query[class_3]">
		<input type='text' url="{'/AutoComplete/productClass'|U}" where="{"class_level=3"|urlencode}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=4}
	<dt>
		<label>{$lang.class_name_4}：</label>
		<input type="hidden" name="query[class_4]">
		<input type='text' url="{'/AutoComplete/productClass'|U}" where="{"class_level=4"|urlencode}" jqac>
	</dt>
	{/if}
	{/if}
	{/if}
	{/if}
	<dt>
		<label>{$lang.stop_date}：</label>
		<input type="text" name="stop_date" class="Wdate spc_input" onClick="WdatePicker()"/>
	</dt>
	<dt>
		<label>{if 'storage_format'|C>=2}{$lang.quantity_less_than}{else}{$lang.sku_less_than}{/if}：</label>
		<input type="text" name="having_quantity_less_than" class="spc_input" value="{$smarty.request.having_quantity_less_than}" />
	</dt>    
</dl>	
<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note tabs="saleStorage" expand=true}
<div id="print" class="width98">
{if sale_storage_show_type|C==2}
{include file="SaleStorage/listByProduct.tpl"}
{else}
{include file="SaleStorage/list.tpl"}
{/if}
</div> 

