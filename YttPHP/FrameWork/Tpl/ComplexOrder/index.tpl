{wz}
<form method="POST" action="{"ComplexOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label >{$lang.deal_no}：</label>
			<input value="{$smarty.post.sale_order.like.sale_order_no}" type="text" name="sale_order[like][sale_order_no]" url="{'/AutoComplete/saleDealNo'|U}" jqac>
		</dt>
		<dt>
			<label >{$lang.orderno}：</label>
			<input value="{$smarty.post.sale_order.like.order_no}" type="text" name="sale_order[like][order_no]" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.warehouse_name}：</label>
			<input value="{$smarty.post.sale_order.query.warehouse_id}" type="hidden" name="sale_order[query][warehouse_id]">
			<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.product_id}：</label>
			<input value="{$smarty.post.sale_order_detail.query.product_id}" name="sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.sale_date_from}：</label>
			<input type="text" name="sale_order[date][needdate_from_order_date]" value="{$smarty.post.date.needdate_from_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="sale_order[date][needdate_to_order_date]" value="{$smarty.post.date.needdate_to_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>  
		<dt>
			<label>{$lang.delivery_personnel}：</label>
			<input value="{$smarty.post.sale_order.query.add_user}" type="hidden" name="sale_order[query][add_user]">
			<input value="{$smarty.post.temp.add_real_name}" name="temp[add_real_name]" type='text' url="{'/AutoComplete/addUserRealName'|U}" jqac>
		</dt>
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="ComplexOrder/list.tpl"}
</div> 