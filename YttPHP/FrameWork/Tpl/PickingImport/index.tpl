{wz}
<form method="POST" action="{'PickingImport/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	<dt><label>{$lang.picking_import_no}：</label>
		<input name="query[id]" type='hidden' />
		<input name="temp[file_list_no]" url="{'/AutoComplete/pickingImportNo'|U}" jqac>
	</dt>		
	{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.warehouse_name}：</label>
			<input type="hidden" id="warehouse_id" name="query[warehouse_id]" >
			<input type="text" name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" jqac /> 
		</dt> 							
	{/if}	
	<dt class="w320">
		<label>{$lang.doc_date}{$lang.from_date}：</label>
		<input type="text" name="date[needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="date[needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
	</dt>
	<dt class="w200">
		<label>{$lang.has_undeal_quantity}：</label>
		<input type="checkbox" name="has_undeal_quantity" value="1" {if $smarty.post.has_undeal_quantity eq 1}checked="checked"{/if} />
	</dt> 	
</dl>
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="PickingImport/list.tpl"}
</div>  