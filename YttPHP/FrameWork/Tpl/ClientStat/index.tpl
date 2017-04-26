{wz}
{if $smarty.get.flag==1}
		{assign var=pass    value=true}
{/if}
<form method="POST" action="{"ClientStat/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
			{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<dt>
				<label >{$lang.factory_name}：</label>
				<input type="hidden" name="query[comp_id]" value="{$smaty.get.query.comp_id}">
				<input type="text" name="client_name" url="{'/AutoComplete/factory'|U}" jqac>
			</dt>  
			{else}
				<input type="hidden" name="query[comp_id]" value="{$login_user.company_id}">
			{/if}			
            {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                <dt>
                <label>{$lang.warehouse_name}：</label>
                <input value="{$smarty.get.query.warehouse_id}" type="hidden" name="warehouse_id">
                <input name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                </dt>
            {/if}
			<dt>
				<label>{$lang.from_date}：</label>
					<input type="text" name="date[from_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
					<label>{$lang.to_date}</label>
					<input type="text" name="date[to_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			</dt>  
			{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<dt>
				<label>{$lang.cli_not_arrearage}：</label>
				 <input type="radio" name="show" value="1" {if $smarty.post.show ==1} checked {/if}>{$lang.show} <input type="radio" name="show" value="0"  {if !$smarty.post.show} checked {/if}>{$lang.notshow}
			</dt>  
			{else}
				<input type="hidden" name="show" value="1" />
			{/if}
			{if $pass}
			<dt>
				<label>{$lang.client_need_recharge}：</label>
				 <input type="radio" name="flag" value="1" {if $smarty.get.flag ==1} checked {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$lang.full}:
				 <input type="radio" name="flag" value="0"  {if !$smarty.get.flag} checked {/if}>
			</dt>
			{/if}
		</dl>
__SEARCH_END__
</form>
<br>
{note}
<div id="print" class="width98">
{include file="ClientStat/list.tpl"}
</div> 

