{wz}
<form method="POST" action="{"Adjust/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.adjust_no}：</label>
			<input value="{$smarty.post.main.like.adjust_no}" type="text" name="main[like][adjust_no]" url="{'/AutoComplete/adjustNo'|U}" jqac>
		</dt>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
			<dt>
				<label>{$lang.warehouse_name}：</label>
				<input type="hidden" id="warehouse_id" name="detail[query][warehouse_id]" >
				<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
			</dt> 							
		{/if}	
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.detail.query.product_id}" name="detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>	
		<dt>
			<label>{$lang.custom_barcode}：</label>
			<input  value="{$smarty.post.detail.query.custom_barcode}" name="detail[query][custom_barcode]"  type='text' class="spc_input">
		</dt>
		<dt>
			<label>{$lang.doc_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	

		<!--dt>
			<label>{$lang.doc_staff}：</label>
			<input value="{$smarty.post.sale_order.query.add_user}" type="hidden" name="main[query][add_user]">
			<input value="{$smarty.post.temp.add_real_name}" name="temp[add_real_name]" type='text' url="{'/AutoComplete/addUserRealNameCommon'|U}" jqac>
		</dt-->
            	<!--dt>
			<label>{$lang.start_adjust_date}：</label>
            		<input type="text" name="main[date][from_adjust_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		<label>{$lang.to_date}</label>
            		<input type="text" name="main[date][to_adjust_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt-->
            	{*warehouse type="dt" title=$lang.warehouse hidden=["name"=>"detail[query][warehouse_id]"]  name="warehouse_name" empty="true"*} 
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="Adjust/list.tpl"}
</div> 

