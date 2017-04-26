{wz}
<form method="POST" action="{'ClientArrearages/index'|U}" id="search_form">
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
                        <input value="{$smarty.post.query.warehouse_id}" type="hidden" name="query[warehouse_id]">
                        <input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                        </dt>
                    {/if}
                    {company  type="dt" title=$lang.basic_name
					hidden=['name'=>'query[basic_id]','id'=>'basic_id']
					name='basic_name'}					
					<dt>
						<label>{$lang.funds_class}：</label>
						<input type='hidden' name="query[pay_class_id]" />
						<input type="text" url="{'/AutoComplete/fundsClassName'|U}" where="{" to_hide=1 and relation_object=2 and pay_type=1 "|urlencode}" jqac>						
	            	</dt>
					<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_paid_date]" value="{$smarty.post.date.from_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="date[to_paid_date]" value="{$smarty.post.date.to_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note export=true insert=$login_user.role_type!=C('SELLER_ROLE_TYPE')}
<div id="print" class="width98">
{include file="ClientArrearages/list.tpl"}
</div> 
