{wz}
<form method="POST" action="{"InvoiceIn/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.supplier}：</label> 
			<input type="hidden" name="query[factory_id]" >
			{if 'invoice.factory_from'|C==1}
			<input type="text"  name="supplier_name" url="{'AutoComplete/factory'|U}" jqac />
			{else}
			<input type="text" name="supplier_name" url="{'AutoComplete/invoiceFactory'|U}" jqac />
			{/if}		
		</dt>
		<dt class="w320">
			<label>{$lang.invoice_date_from}：</label>
			<input type="text" name="date[from_invoice_date]" class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}：</label>
			<input type="text" name="date[to_invoice_date]" class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>
		<dt>
			<label>{$lang.invoice_no}：</label>
			<input type="text" name="query[invoice_no]" url="{'AutoComplete/invoiceInInvoiceNo'|U}" jqac />
		</dt>
		{invoiceCompany type='dt' title=$lang.basic_name  hidden=['name'=>'query[basic_id]']} 			
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InvoiceIn/list.tpl"}
</div> 