{wz}
<form method="POST" action="{"InvoiceProfit/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.product_name}：</label> 
			<input type="hidden" name="query[invoice_storage_log.product_id]">
			<input type="text" name="product_name" url="{'AutoComplete/invoiceStorageProductName'|U}" jqac />					
		</dt>		
		<dt>
			<label>{$lang.date}：</label> 
			<input type="text" name="date[lt_object_date]" class="Wdate" onclick="WdatePicker()" />					
		</dt>		
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InvoiceProfit/list.tpl"}
</div> 