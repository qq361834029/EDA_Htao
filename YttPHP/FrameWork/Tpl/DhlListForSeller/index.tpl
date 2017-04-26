{wz}
<form method="POST" action="{"{$smarty.const.MODULE_NAME}/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
			<dl>
				<dt>
					<label>{$lang.deal_no}：</label>
					<input type="hidden" name="main[query][object_id]"  value="{$smarty.post.main.query.object_id}"/>
					<input name="temp[object_no]" value="{$smarty.post.temp.object_no}" url="{'/AutoComplete/dhlObjectNo'|U}" jqac>
				</dt>
				{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
				<dt>
					<label>{$lang.belongs_warehouse}：</label>
					<input value="{$smarty.post.sale_order.query.sale_order_warehouse_id}" type="hidden" name="sale_order[query][s.warehouse_id]">
					<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>
				</dt>
				{/if}
				{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
				<dt>
					<label>{$lang.belongs_seller}：</label>
					<input value="{$smarty.post.sale_order.query.sale_order_factory_id}" type='hidden' name="sale_order[query][s.factory_id]">
					<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
				</dt>
				{/if}
			</dl> 
__SEARCH_END__
</form> 
{note tabs="dhlList"}
<div id="print" class="width98">
{include file="{$smarty.const.MODULE_NAME}/list.tpl"}
</div> 
