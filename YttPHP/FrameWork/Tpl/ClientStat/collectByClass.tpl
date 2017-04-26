{wz print=false}
<form method="POST" action="{'ClientStat/collectByClass'|U}"  beforeSubmit="checkSearchForm" validity="empty" id="search_form">
<div style="padding-top:12px;"></div>
__SEARCH_START__
			<dl> 
					{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
					<dt>
						<label>{$lang.factory_name}：</label>
						<input type='hidden' name="query[comp_id]" class="valid-required" />
						<input type='text' url="{'/AutoComplete/factory'|U}" jqac>__*__
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
						<label>{$lang.funds_class}：</label>
						<input type='hidden' name="query[pay_class_id]"/>
						<input type="text" name="temp[pay_class_name]" url="{'/AutoComplete/fundsClassName'|U}" where="{" to_hide=1 and relation_object=2"|urlencode}" jqac>
	            	</dt> 						
	            	{company  type="dt" title=$lang.basic_name hidden=['name'=>'query[basic_id]','id'=>'basic_id','value'=>$smarty.get.basic_id, 'class'=>'valid-required'] name='basic_name' require=true}
					{currency data=C('CLIENT_CURRENCY') name="query[currency_id]" id="currency_id" value=$smarty.get.currency_id type='dt' title=$lang.currency_name require="true"  class="valid-required"}  
					<dt>
					<label>{$lang.funds_date}{$lang.from}：</label>
						{assign var="date_suffix" value="_"|cat:time()|cat:rand(1,999)}
						<input type="text" id="date_from{$date_suffix}" name="date[from_paid_date]" value="{$smarty.get.from_paid_date}" class="valid-required Wdate spc_input_data" onClick="WdatePicker({ minDate:'#F{ $dp.$D(\'date_to{$date_suffix}\',{ M:-2,d:1 });}',maxDate:'#F{ $dp.$D(\'date_to{$date_suffix}\'); }' })"/>__*__
						<label>{$lang.to_date}</label>
						<input type="text" id="date_to{$date_suffix}" name="date[to_paid_date]" value="{$smarty.get.to_paid_date}" class="valid-required Wdate spc_input_data" onClick="WdatePicker({ minDate:'#F{ $dp.$D(\'date_from{$date_suffix}\'); }',maxDate:'#F{ $dp.$D(\'date_from{$date_suffix}\',{ M:2,d:-1 }); }' })"/>__*__						
            		</dt> 
			</dl> 
__SEARCH_END__
</form>

{note}
<div id="print" class="width98">
{include file="ClientStat/list_collectByClass.tpl"}
</div>