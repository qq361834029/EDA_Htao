{wz}
<form method="POST" action="{'InstockImport/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	<dt><label>{$lang.instock_no}：</label>
		<input name="query[a.id]" type='hidden' />
		<input name="temp[file_list_no]" url="{'/AutoComplete/instockImportNo'|U}" jqac>
	</dt>		
    <dt>
		<label>{$lang.delivery_no}：</label>
		<input type="hidden" name="query[b.relation_id]" />
		<input type="text" name="temp[instock_no]" url="{'AutoComplete/instockNo'|U}" jqac />
	</dt>
	{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.warehouse_name}：</label>
			<input type="hidden" id="warehouse_id" name="query[a.warehouse_id]" >
			<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
		</dt> 							
	{/if}	
	<dt class="w320">
		<label>{$lang.doc_date}{$lang.from_date}：</label>
		<input type="text" name="date[needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="date[needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
	</dt> 	
</dl>
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="InstockImport/list.tpl"}
</div>  