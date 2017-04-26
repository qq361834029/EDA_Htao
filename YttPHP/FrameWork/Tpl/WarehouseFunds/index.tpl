{wz}
<form method="POST" action="{'WarehouseFunds/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
                    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                        <dt>
                        <label>{$lang.warehouse_name}：</label>
                        <input value="{$smarty.post.query.warehouse_id}" type="hidden" name="query[warehouse_id]">
                        <input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                        </dt>
                    {/if}
					{currency data=C('COMPANY_CURRENCY') name="query[currency_id]" id="currency_id" value=$rs.currency_id type='dt' title=$lang.currency_no}
                    <dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_paid_date]" value="{$smarty.post.date.from_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="date[to_paid_date]" value="{$smarty.post.date.to_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="WarehouseFunds/list.tpl"}
</div> 
