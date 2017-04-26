{wz}
<form method="POST" action="{"ReturnSaleOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.warehouse_name}：</label>
			<input value="{$smarty.post.return_sale_order_detail.query.warehouse_id}" type="hidden" name="return_sale_order_detail[query][warehouse_id]">
			<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
		</dt>
		{/if}
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}  
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input value="{$smarty.post.main.query.factory_id}" type='hidden' name="main[query][factory_id]">
			<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
		</dt> 
		{/if}		
	</dl>
__SEARCH_END__
</form>
{note}__SCROLL_BAR_START__
<div id="print" class="width98">
{include file="ReturnSaleOrder/remind_list.tpl"}
</div> __SCROLL_BAR_END__