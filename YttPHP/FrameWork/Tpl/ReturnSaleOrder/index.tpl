{wz}
<form method="POST" action="{"ReturnSaleOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
        <input id="rand" type="hidden" name="rand" value="{$rand}">
		<dt>
			<label>{$lang.return_sale_order_no}：</label>
			<input type="hidden" name="main[query][id]" id="id" value="{$smarty.post.main.query.id}">
			<input type="text" value="{$smarty.post.temp.return_sale_order_no}" name="temp[return_sale_order_no]" url="{'AutoComplete/returnSaleOrderNo'|U}" jqac >
		</dt>  
		<dt>
			<label>{$lang.deal_no}：</label>
			<input value="{$smarty.post.main.query.sale_order_no}" type="text" name="main[query][sale_order_no]" url="{'/AutoComplete/saleDealNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.orderno}：</label>
			<input value="{$smarty.post.main.query.order_no}" type="text" name="main[query][order_no]" url="{'/AutoComplete/returnOrderNo'|U}" jqac>
		</dt>
		<dt>
		  <label>{$lang.return_track_no}：</label>
		  <input type="text" class="spc_input" name="main[like][return_track_no]" id="return_track_no">
		</dt>
		<dt>
			<label>{$lang.clientname}：</label>
			<input value="{$smarty.post.client.like.comp_name}" type='text' name="client[like][comp_name]" class="spc_input">
		</dt>     
		<dt>
			<label><span class="return_data">{$lang.return_sale_date_from}：</span></label>
			<input type="text" name="main[date][needdate_from_return_order_date]" class="Wdate spc_input_data" value="{$smarty.post.main.date.needdate_from_return_order_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_return_order_date]" class="Wdate spc_input_data" value="{$smarty.post.main.date.needdate_to_return_order_date}"  onClick="WdatePicker()"/>
		</dt>   
		<dt>
			<label>{$lang.return_order_no}：</label>
			<input value="{$smarty.post.return_sale_order_addition.like.return_order_no}" type='text' name="return_sale_order_addition[like][return_order_no]" url="{'/AutoComplete/getReturnOrderNo'|U}" jqac>
		</dt> 
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.return_sale_order_detail.query.product_id}" name="return_sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label> 
			<input value="{$smarty.post.return_sale_order_detail.like.product_no}" type='text' name="return_sale_order_detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>   
		<dt>
			<label>{$lang.return_sale_order_state}：</label>
			{select value=$smarty.post.main.query.return_sale_order_state data=C('RETURN_SALE_ORDER_STATE') name='main[query][return_sale_order_state]' id='return_sale_order_state' initvalue="1" combobox="1"}
		</dt>   		
		<dt>
			<label>{$lang.return_reason}：</label>
			{select data=C('RETURN_REASON') value="{$smarty.post.main.query.return_reason}" name='main[query][return_reason]' combobox=1}
		</dt>
        {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}  
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input value="{$smarty.post.main.query.factory_id}" type='hidden' name="main[query][factory_id]">
			<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
		</dt> 
		{/if}
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_warehouse}：</label>
			<input value="{$smarty.post.return_sale_order_detail.query.warehouse_id}" type="hidden" name="return_sale_order_detail[query][warehouse_id]">
			<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
		</dt>
		{/if}	
		<dt>
			<label>{$lang.whether_related_deal_no}：</label>
			{select data=C('WHETHER_RELATED_DEAL_NO') combobox="1" value=$smarty.post.main.query.is_related_sale_order name="main[query][is_related_sale_order]"}
		</dt>
        {if in_array($smarty.const.LANG_SET,array('de'))}
        <dt>
        </dt>
        {/if}
		<dt>
			<label><span class="return_data">{$lang.returned_date}：</span></label>
			<input type="text" name="main[date][needdate_from_returned_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_returned_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_returned_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_returned_date}"  onClick="WdatePicker()"/>
		</dt>   
        <dt>
			<label>{$lang.doc_staff}：</label>
			<input value="{$smarty.post.main.query.add_user}" type='hidden' name="temp[real_name]">
			<input value="{$smarty.post.temp.add_real_name}" name="user[like][real_name]" type='text' url="{'/AutoComplete/returnAddUserName'|U}" jqac>
		</dt> 
		<dt>
		  <label>{$lang.return_logistics_no}：</label>
		  <input type="text" class="spc_input" jqac name="main[like][return_logistics_no]" id="return_logistics_no" url="{'/AutoComplete/returnLogisticsNo'|U}">
		</dt>
	</dl>
__SEARCH_END__
</form>
{note export=true}
__SCROLL_BAR_START__
<div id="print" class="width98">
{include file="ReturnSaleOrder/list.tpl"}
</div> 
__SCROLL_BAR_END__