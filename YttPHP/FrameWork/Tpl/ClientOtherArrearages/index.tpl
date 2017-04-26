{wz}
<form method="POST" action="{'ClientOtherArrearages/index'|U}" beforeSubmit="checkSearchForm" id="search_form">
<div style="padding-top:12px;"></div>
__SEARCH_START__
			<dl> 
                    <input id="rand" type="hidden" value="{$rand}" name="rand">
					{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
					<dt>
						<label>{$lang.factory_name}：</label>
						<input type='hidden' name="query[comp_id]">
						<input type='text' url="{'/AutoComplete/factory'|U}" jqac>
	            	</dt>
					{/if}
                    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                        <dt>
                        <label>{$lang.warehouse_name}：</label>
                        <input value="{$smarty.post.query.warehouse_id}" type="hidden" name="warehouse_id">
                        <input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                        </dt>
                    {/if}
	            	{company  type="dt" title=$lang.basic_name
					hidden=['name'=>'query[basic_id]','id'=>'basic_id']
					name='basic_name'}					
					<dt>
						<label>{$lang.funds_class}：</label>
						<input type='hidden' name="query[pay_class_id]" />
						<input type="text" url="{'/AutoComplete/fundsClassName'|U}" where="{" to_hide=1 and relation_object=2 and pay_type=2 "|urlencode}" jqac>						
	            	</dt> 					
					<dt class="w320">
						<label>{$lang.funds_date}{$lang.from}：</label>
						{assign var="date_suffix" value="_"|cat:time()|cat:rand(1,999)}
						<input type="text" id="date_from{$date_suffix}" name="date[from_paid_date]" value="{$smarty.post.date.from_paid_date}" class="valid-required Wdate spc_input_data" onClick="WdatePicker()"/>__*__
						{$lang.to_date}
						<input type="text" id="date_to{$date_suffix}" name="date[to_paid_date]" value="{$smarty.post.date.to_paid_date}" class="valid-required Wdate spc_input_data" onClick="WdatePicker()"/>__*__
            		</dt> 
			</dl> 
__SEARCH_END__
<input type="hidden" id="flow" value="ClientOtherArrearages">
</form> 
{note export=true insert=!$is_factory}
<div id="print" class="width98">
{include file="ClientOtherArrearages/list.tpl"}
</div> 
