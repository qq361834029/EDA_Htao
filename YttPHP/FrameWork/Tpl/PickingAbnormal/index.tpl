{wz}
<form method="POST" action="{'PickingAbnormal/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	<dt><label>{$lang.picking_no}：</label>
		<input name="main[query][id]" type='hidden' />
		<input name="temp[file_list_no]" url="{'/AutoComplete/pickingImportNo'|U}" jqac>
	</dt>		
	{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
	<dt>
		<label>{$lang.warehouse_name}：</label>
		<input type="hidden" id="warehouse_id" name="main[query][warehouse_id]" >
		<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
	</dt> 		
	{/if}
	<dt style="margin:auto 100px;">
		<label>{$lang.location_no}：</label>
		<input type="text" name="detail[like][barcode_no]" url="{'AutoComplete/pickingImportBarcode'|U}" jqac /> 
                
	</dt> 		
	<dt>
		<label>{$lang.product_id}：</label>
		<input type="text" name="main[query][product_id]" class="spc_input" value="{$smarty.post.main.query.product_id}" />
	</dt> 	
	<dt class="w320">
		<label>{$lang.doc_process_date}{$lang.from}：</label>
		<input type="text" name="detail[date][needdate_from_update_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="detail[date][needdate_to_update_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
	</dt> 	
	<dt>
		<label>{$lang.process_state}：</label>
		{select data=C('CFG_FILE_IMPORT_STATE') name="detail[query][state]" initvalue=$smarty.post.detail.query.state combobox="1" filter=C('CFG_IMPORT_SUCCESS_STATE')}
	</dt> 	
</dl>
__SEARCH_END__
</form> 
{note insert=false}
<div id="print" class="width98">
{include file="PickingAbnormal/list.tpl"}
</div>  