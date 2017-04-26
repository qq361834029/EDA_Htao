{wz}
<form method="POST" action="{"InvoiceInitStorage/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt class="w320">
			<label>{$lang.from_date}：</label>
			<input type="text" name="date[from_init_date]" class="Wdate spc_input_data" onclick="WdatePicker()"/>
			{$lang.to_date}：
			<input type="text" name="date[to_init_date]" class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>		
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InvoiceInitStorage/list.tpl"}
</div> 