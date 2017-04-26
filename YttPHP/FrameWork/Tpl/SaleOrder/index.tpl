{wz}
<form method="POST" action="{"SaleOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<input type="hidden" name="mac_address" id="mac_address" value="" class="spc_input">
	<dl>
		<dt>
			<label>{$lang.deal_no}：</label>
			<input value="{$smarty.post.sale_order.query.sale_order_no}" type="text" name="sale_order[query][sale_order_no]" url="{'/AutoComplete/saleDealNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.orderno}：</label>
			<input value="{$smarty.post.sale_order.query.order_no}" type="text" name="sale_order[query][order_no]" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.clientname}：</label>
			<input value="{$smarty.post.client.like.comp_name}" type='text' name="client[like][comp_name]" class="spc_input">
		</dt>
		<dt>
			<label>{$lang.belongs_country}：</label>
			<input value="{$smarty.post.sale_order_addition.like.country_name}" type='text' name="sale_order_addition[like][country_name]" class="spc_input">
		</dt>
		<dt>
			<label>{$lang.consignee}：</label>
			<input value="{$smarty.post.sale_order_addition.like.consignee}" type='text' name="sale_order_addition[like][consignee]" class="spc_input">
		</dt>
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.sale_order_detail.query.product_id}" name="sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.sale_order_detail.query.product_no}" type='text' name="sale_order_detail[query][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>
        <dt>
			<label>{$lang.product_barcode}：</label>
			<input value="{$smarty.post.sale_order_detail.query.custom_barcode}" type='text' name="sale_order_detail[query][custom_barcode]" url="{'/AutoComplete/productBarcode'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.express_way}：</label>
			<input value="{$smarty.post.sale_order.query.express_id}" type="hidden" name="sale_order[query][express_id]">
			<input value="{$smarty.post.temp.express_name}" name="temp[express_name]" type='text' url="{'/AutoComplete/shipping'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.track_no}：</label>
			<input value="{$smarty.post.sale_order.query.track_no}" type='text' name="sale_order[query][track_no]" url="{'/AutoComplete/trackNo'|U}" jqac>
		</dt>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.shipping_warehouse}：</label>
			<input value="{$smarty.post.sale_order.query.sale_order_warehouse_id}" type="hidden" name="sale_order[query][sale_order.warehouse_id]">
			<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>
		</dt>
		{/if}
		<dt>
			<label>{$lang.sale_date_from}：</label>
			<input type="text" name="sale_order[date][needdate_from_order_date]" value="{$smarty.post.sale_order.date.needdate_from_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="sale_order[date][needdate_to_order_date]" value="{$smarty.post.sale_order.date.needdate_to_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
		<dt>
			<label>{$lang.order_type}：</label>
            <input type="hidden" value=""{$smarty.post.sale_order.query.order_type}" name="sale_order[query][order_type]" id='order_type' value="{$smarty.post.return_sale_order_detail.query.order_type}" class="spc_input">
            <input type='text' name="temp[order_type_name]" id='order_type_name' {$smarty.post.temp.order_type_name} url="{'/AutoComplete/orderTypeTag'|U}" jqac>
        </dt>
		<dt>
			<label>{$lang.state}：</label>
			{select value=$smarty.post.sale_order.query.sale_order_state data=C('SALE_ORDER_STATE') name='sale_order[query][sale_order_state]' id='sale_order_state' initvalue="1" combobox="1"}
		</dt>
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input value="{$smarty.post.sale_order.query.sale_order_factory_id}" type='hidden' name="sale_order[query][sale_order.factory_id]">
			<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
		</dt>
		{/if}
        <dt>
			<label>{$lang.out_stock_date}：</label>
			<input type="text" name="sale_order[date][mt_send_date]" value="{$smarty.post.sale_order.date.mt_send_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="sale_order[date][lt_send_date]" value="{$smarty.post.sale_order.date.lt_send_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
        <dt>
			<label>{$lang.postcode}：</label>
			<input value="{$smarty.post.sale_order_addition.query.post_code}" type='text' name="sale_order_addition[query][post_code]" class="spc_input">
		</dt>
        <dt>
			<label>{$lang.return_sale_date_from}：</label>
			<input type="text" name="return_sale_order[date][mt_return_order_date]" value="{$smarty.post.date.needdate_from_insert_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="return_sale_order[date][lt_return_order_date]" value="{$smarty.post.date.needdate_to_insert_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>
        <dt>
            <label>{$lang.has_track_no}：</label>
            {select data=C('YES_NO') value=$smarty.post.has_track_no name="has_track_no" initvalue=-2 combobox=''}
		</dt>
        <dt>
            <label>{$lang.insure}：</label>
            {select data=C('IS_INSURE') value=$smarty.post.is_insure name="sale_order[query][is_insure]" initvalue='-2' combobox=''}
        </dt>
        <dt>
            <label>{$lang.out_stock_type}：</label>
            {select data=C('SALE_ORDER_OUT_STOCK_TYPE') value=$smarty.post.out_stock_type name="sale_order[query][out_stock_type]"  initvalue='-2' combobox=''}
        </dt>
        <dt>
            <label>{$lang.last_operation}：</label>
            <input type="text" name="sale_order[date][sale_order.mt_update_time]" value="{$smarty.post.sale_order.date.mt_update_time}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            <label>{$lang.to_date}</label>
            <input type="text" name="sale_order[date][sale_order.lt_update_time]" value="{$smarty.post.sale_order.date.lt_update_time}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
        </dt>
		<dt>
            <label>{$lang.consigner}：</label>
            <input value="{$smarty.post.state_log.query.user_id}" type="hidden" name="state_log[query][user_id]">
			<input value="{$smarty.post.temp.consigner}" name="temp[consigner]" type='text' url="{'/AutoComplete/saleOrderConsigner'|U}" jqac>
        </dt>
	</dl>
	<input type="hidden" name="date_key" value="4">
__SEARCH_END__
</form>
{note batch_upload=true export=true all_delete=$login_user.role_type==C('SELLER_ROLE_TYPE')}
<!--export=true combine=$login_user.role_type==C('SELLER_ROLE_TYPE')-->
__SCROLL_BAR_START__
    <div id="print" class="width98">
        {include file="SaleOrder/list.tpl"}
    </div>
__SCROLL_BAR_END__
<script>
	$(document).ready(function(){
		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$dom.find('#mac_address'));
	});
</script>