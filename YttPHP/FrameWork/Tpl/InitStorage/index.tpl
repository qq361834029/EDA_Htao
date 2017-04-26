{wz}
<form method="POST" action="{"InitStorage/index"|U}" id="search_form">
__SEARCH_START__
		<dl>
		<dt>
					<label>{$lang.init_no}：</label>
					<input type="text" name="main[like][init_storage_no]" url="{'/AutoComplete/initStorageNo'|U}" jqac>
				</dt>
				<dt>
					<label>{$lang.product_no}：</label>
					<input type="hidden" name="detail[query][product_id]">
					<input type="text" url="{'/AutoComplete/product'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.start_init_date}：</label>
            		<input type="text" name="main[date][from_init_storage_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		<label>{$lang.end_init_date}</label>
            		<input type="text" name="main[date][to_init_storage_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>
            	{warehouse type="dt" title=$lang.warehouse hidden=["name"=>"main[query][warehouse_id]"]  name="warehouse_name" empty="true"} 
		</dl>	
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InitStorage/list.tpl"}
</div> 

