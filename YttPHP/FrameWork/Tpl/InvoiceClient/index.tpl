{wz}
<form method="POST" action="{"InvoiceClient/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.client_name}：</label> 
			<input type="text" name="like[company_name]" url="{'AutoComplete/invoiceClientName'|U}" jqac />					
		</dt>
		<dt>
			<label>{$lang.tax_no}：</label>
			<input type="text" name="like[tax_no]" url="{'AutoComplete/InvoiceClientTaxNo'|U}" jqac />
		</dt>
		<dt>	
		<label>{$lang.state}：</label>
		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" combobox=1}
	</dt>				
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InvoiceClient/list.tpl"}
</div> 