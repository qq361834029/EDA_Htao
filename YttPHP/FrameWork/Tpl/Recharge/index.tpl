{wz}
<form method="POST" action="{'Recharge/index'|U}" id="search_form">
<input type="hidden" id="rand" name="rand" value="{$rand}">
__SEARCH_START__
	<dl> 
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input type="hidden" name="query[factory_id]" value="{$smarty.post.query.factory_id}">
			<input id="factory_email" name="temp[factory_email]" value="{$smarty.post.temp.factory_email}" url="{'/AutoComplete/factoryEmail'|U}" jqac>
		</dt> 
		{else}
			<input type="hidden" name="query[factory_id]" value="{$login_user.company_id}">
		{/if}
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
            <dt>
            <label>{$lang.warehouse_name}：</label>
            <input value="{$smarty.post.query.warehouse_id}" type="hidden" name="query[warehouse_id]">
            <input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
            </dt>
        {/if}
		<dt><label>{$lang.bank_name}：</label>
			<input type="hidden" name="query[bank_id]" />
			<input name="temp[bank_name]" type="text" url="{'/AutoComplete/bank'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.recharge_date}{$lang.from}：</label>
			<input type="text" name="date[from_recharge_date]" value="{$smarty.post.date.from_recharge_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="date[to_recharge_date]" value="{$smarty.post.date.to_recharge_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>	
		<dt>
			<label>{$lang.confirm}{$lang.date}：</label>
			<input type="text" name="date[from_confirm_date]" value="{$smarty.post.date.from_confirm_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="date[to_confirm_date]" value="{$smarty.post.date.to_confirm_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>		
		<dt><label>{$lang.state}：</label>
			{select data=C('CONFIRM_STATE') name="query[confirm_state]" value="`$smarty.post.query.confirm_state`" combobox=1}
		</dt>	
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="Recharge/list.tpl"}
</div> 
