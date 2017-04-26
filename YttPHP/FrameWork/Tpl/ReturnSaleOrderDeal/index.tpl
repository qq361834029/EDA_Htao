{wz}
<form method="POST" action="{"ReturnSaleOrderDeal/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.return_sale_order_no}：</label>
            <input type="hidden" name="submit_type" value="1">
			<input type="hidden" name="main[query][b.id]" id="id" value="{$smarty.post.main.query.id}">
			<input type="text" value="{$smarty.post.temp.return_sale_order_no}" name="temp[return_sale_order_no]" url="{'AutoComplete/returnSaleOrderNo'|U}" jqac >
		</dt> 
		<dt>
			<label>{$lang.return_instock_date}：</label>
			<input type="text" name="return_sale_order_storage[date][needdate_from_storage_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_storage_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="return_sale_order_storage[date][needdate_to_storage_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_storage_date}"  onClick="WdatePicker()"/>
		</dt> 
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.return_sale_order_detail.query.product_id}" name="return_sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label> 
			<input value="{$smarty.post.return_sale_order_detail.like.product_no}" type='text' name="return_sale_order_detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>    
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}  
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input value="{$smarty.post.main.query.factory_id}" type='hidden' name="main[query][factory_id]">
			<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
		</dt> 
		<dt>
			<label>{$lang.process_state}：</label>
			{select data=C("RETURN_PROCESS_STATUS") name="main[query][return_process_status]" combobox="1"}
		</dt>
		<dt>
			<label>{$lang.treatment}：</label>
			{select data=C("RETURN_PROCESS_MODE") name="main[query][return_process_mode]" combobox="1"}
		</dt>
		{/if}
	</dl>
__SEARCH_END__
</form>
{note print=true}
<div id="print" class="width98">
{include file="ReturnSaleOrderDeal/list.tpl"}
</div> 