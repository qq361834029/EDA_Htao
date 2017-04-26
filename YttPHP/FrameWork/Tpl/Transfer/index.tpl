{wz}
<form method="POST" action="{"Transfer/index"|U}" id="search_form">
__SEARCH_START__
		<dl>
		<dt>
					<label>{$lang.transfer_no}：</label>
					<input type="text" name="main[like][transfer_no]" url="{'/AutoComplete/transferNo'|U}" jqac>
				</dt>
				<dt>
					<label>{$lang.product_no}：</label>
					<input type="hidden" name="detail[query][product_id]">
					<input type="text" url="{'/AutoComplete/product'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.start_transfer_date}：</label>
            		<input type="text" name="main[date][from_transfer_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		<label>{$lang.end_transfer_date}</label>
            		<input type="text" name="main[date][to_transfer_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>
            	{warehouse type="dt" title=$lang.in_warehouse hidden=["name"=>"detail[query][in_warehouse_id]"]  name="warehouse_name" empty="true"} 
            	{warehouse type="dt" title=$lang.out_warehouse hidden=["name"=>"detail[query][warehouse_id]"]  name="warehouse_name" empty="true"} 
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="Transfer/list.tpl"}
</div> 

