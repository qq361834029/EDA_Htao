{wz}
<form method="POST" action="{"WarehouseAccount/index"|U}" id="search_form">
__SEARCH_START__
	<dl><input type="hidden" id="rand" name="rand" value="{$rand}">
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<dt>
				<label>{$lang.factory_name}：</label>
				<input type="hidden" id="factory_id" name="query[factory_id]" >
				<input type="text" name="temp[w_name]" url="{'AutoComplete/factory'|U}" jqac /> 
			</dt> 							
		{/if}
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
			<dt>
				<label>{$lang.warehouse_name}：</label>
				<input type="hidden" id="warehouse_id" name="query[warehouse_id]" >
				<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
			</dt> 							
		{/if}
		<dt>
			<label>{$lang.balance_date}{$lang.from}：</label>
			<input type="text" name="date[mt_account_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="date[lt_account_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>
    </dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note insert=false print=false export=true}
<div id="print" class="width98">
{include file="WarehouseAccount/list.tpl"}
</div> 

