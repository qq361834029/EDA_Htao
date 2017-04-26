{wz}
<form method="POST" action="{"DomesticWaybill/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.waybill_no}：</label>
			<input value="{$smarty.post.main.like.waybill_no}" type="text" name="main[like][waybill_no]" url="{'/AutoComplete/waybillNo'|U}" jqac>
		</dt>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
			<dt>
				<label>{$lang.warehouse_name}：</label>
				<input type="hidden" id="warehouse_id" name="detail[query][warehouse_id]" >
				<input type="text" name="temp[w_name]" url="{'AutoComplete/noReturnSoldWarehouse'|U}" jqac /> 
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
			<label>{$lang.waybill_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_waybill_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_waybill_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
    </dl>
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="DomesticWaybill/list.tpl"}
</div> 

