{wz}
<form method="POST" action="{"{$smarty.const.MODULE_NAME}/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
			<dl>
				<dt>
					<label>{$lang.deal_no}：</label>
					<input type="hidden" name="main[query][object_id]"  value="{$smarty.post.main.query.object_id}"/>
					<input name="temp[object_no]" value="{$smarty.post.temp.object_no}" url="{'/AutoComplete/correosObjectNo'|U}" jqac>
				</dt>
				<dt>
					<label>{$lang.request_type}：</label>
				{select data=C('EXPRESS_API_REQUEST_TYPE') name="main[query][request_type]" value="`$smarty.post.main.query.request_type`" combobox=1 }
            	</dt>
				<dt>
					<label>{$lang.request_status}：</label>
					{select data=C('EXPRESS_API_REQUEST_STATUS') name="main[query][request_status]" value="`$smarty.post.main.query.request_status`" combobox=1 allow=C('EXPRESS_API_ALLOW_REQUEST_STATUS')}
            	</dt>
				{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
				<dt>
					<label>{$lang.shipping_warehouse}：</label>
					<input value="{$smarty.post.sale_order.query.sale_order_warehouse_id}" type="hidden" name="sale_order[query][sale_order.warehouse_id]">
					<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>
				</dt>
				{/if}
				{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
				<dt>
					<label>{$lang.belongs_seller}：</label>
					<input value="{$smarty.post.sale_order.query.sale_order_factory_id}" type='hidden' name="sale_order[query][sale_order.factory_id]">
					<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
				</dt>
				{/if}
			</dl> 
__SEARCH_END__
</form> 
{note tabs="correosList"}
<div id="print" class="width98">
{include file="{$smarty.const.MODULE_NAME}/list.tpl"}
</div> 
