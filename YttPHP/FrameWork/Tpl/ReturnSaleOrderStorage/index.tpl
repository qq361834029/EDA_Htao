{wz}
<form method="POST" action="{"ReturnSaleOrderStorage/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
            <input type="hidden" name="rand" id="rand" value="{$rand}">
			<label>{$lang.return_sale_order_no}：</label>
            <input type="hidden" name="submit_type" value="1">
			<input type="hidden" name="main[query][b.id]" id="id" value="{$smarty.post.main.query.id}">
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
			<label>{$lang.clientname}：</label>
			<input value="{$smarty.post.client.like.comp_name}" type='text' name="client[like][comp_name]" class="spc_input">
		</dt>     
		<dt>
			<label><span class="return_data">{$lang.return_sale_date_from}：</span></label>
			<input type="text" name="main[date][needdate_from_return_order_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_return_order_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_return_order_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_return_order_date}"  onClick="WdatePicker()"/>
		</dt>   
		<dt>
			<label>{$lang.consignee}：</label>
			<input value="{$smarty.post.return_sale_order_addition.like.consignee}" type='text' name="return_sale_order_addition[like][consignee]" url="{'/AutoComplete/consignee'|U}" jqac>
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
			<label>{$lang.return_reason}：</label>
			{select data=C('RETURN_REASON') value="{$smarty.post.main.query.return_reason}" name='main[query][return_reason]' combobox=1}
		</dt>			
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
			<label>{$lang.order_type}：</label>
            <input type="hidden" name="sale_order[query][order_type]" id='order_type' value="{$smarty.post.main.query.order_type}" class="spc_input">
            <input type='text' name="temp[order_type]" id='order_type_name' {$smarty.post.temp.order_type_name} url="{'/AutoComplete/orderTypeName'|U}" jqac>
        </dt> 
        {if $is_return_sold!=C('NO_RETURN_SOLD')}
        <dt>
			<label>{$lang.return_storage_warehouse}：</label>
			<input value="{$smarty.post.return_sale_order_storage_detail.query.sale_order_warehouse_id}" type="hidden" name="return_sale_order_storage_detail[query][location.warehouse_id]">
			<input value="{$smarty.post.temp.detail_warehouse_name_use}" name="temp[detail_warehouse_name_use]" type='text' url="{'/AutoComplete/noReturnSoldWarehouse'|U}" jqac>
		</dt>	
        {/if}
		<dt>
			<label>{$lang.whether_related_deal_no}：</label>
			{select data=C('WHETHER_RELATED_DEAL_NO') combobox="1" value=$smarty.post.main.query.is_related_sale_order name="main[query][is_related_sale_order]"}
		</dt>
		<dt>
		  <label>{$lang.return_logistics_no}：</label>
		  <input type="text" class="spc_input" jqac name="return_sale_order[like][return_logistics_no]" id="return_logistics_no" url="{'/AutoComplete/returnLogisticsNo'|U}">
		</dt>
		<dt>
		  <label>{$lang.return_track_no}：</label>
		  <input type="text" class="spc_input"  name="return_sale_order[like][return_track_no]" id="return_track_no">
		</dt>
        
        <dt>
			<label>{$lang.doc_process_date}{$lang.from_date}：</label>
			<input type="text" name="state_log[date][needdate_from_create_time]" value="{$smarty.post.state_log.date.needdate_from_create_time}" class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="state_log[date][needdate_to_create_time]" value="{$smarty.post.state_log.date.needdate_to_create_time}" class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>
        
        <dt>
			<label>{$lang.is_out_batch}：</label>
            {select data=C('IS_OUT_BATCH') value=$smarty.post.set_post.query.is_out_batch name="set_post[query][is_out_batch]" combobox=''}
        </dt>
	</dl>
__SEARCH_END__
</form>
{note print=true export=true return_storage=true}
<div id="print" class="width98">
{include file="ReturnSaleOrderStorage/list.tpl"}
</div> 