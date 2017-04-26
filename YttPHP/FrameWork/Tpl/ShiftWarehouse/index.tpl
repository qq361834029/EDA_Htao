{wz}
<form method="POST" action="{"ShiftWarehouse/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.shift_warehouse_no}：</label>
			<input value="{$smarty.post.main.like.shift_warehouse_no}" type="text" name="main[like][shift_warehouse_no]" url="{'/AutoComplete/shiftWarehouseNo'|U}" jqac>
		</dt>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
			<dt>
				<label>{$lang.warehouse_name}：</label>
				<input type="hidden" id="warehouse_id" name="detail[query][out_warehouse_id]" >
				<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
			</dt> 							
		{/if}	
		<dt>
			<label>{$lang.product_barcode}：</label>
			<input type="hidden" value="{$smarty.post.detail.query.product_id}" name="detail[query][product_id]">
			<input value="{$smarty.post.temp.custom_barcode}" type='text' name="temp[custom_barcode]" url="{'/AutoComplete/productBarcode'|U}" jqac>
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>		
		<dt>
			<label>{$lang.shift_warehouse_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_shift_warehouse_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_shift_warehouse_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="ShiftWarehouse/list.tpl"}
</div> 

