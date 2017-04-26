{wz}
<form method="POST" action="{"WarehouseStat/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>  
                {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                    <dt>
                    <label>{$lang.warehouse_name}：</label>
                    <input value="{$smarty.get.query.warehouse_id}" type="hidden" name="query[warehouse_id]">
                    <input name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                    </dt>
                {/if}                    
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
						<input type="text" name="date[to_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>  
            	<dt>
					<label>{$lang.warehouse_not_arrearage}：</label>
					 <input type="radio" name="show" value="1" {if $smarty.post.show ==1} checked {/if}>{$lang.show} <input type="radio" name="show" value="0"  {if !$smarty.post.show} checked {/if}>{$lang.notshow}
            	</dt>    
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="WarehouseStat/list.tpl"}
</div> 

