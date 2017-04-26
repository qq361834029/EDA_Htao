{wz}
<form method="POST" action="{"InvoiceSupplier/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.basic_name}：</label> 
			<input type="text" name="like[company_name]" url="{'AutoComplete/invoiceCompanyName'|U}" jqac />					
		</dt>
		<dt>	
		<label>{$lang.state}：</label>
		{select data=C('BASICSTATE') name="query[to_hide]"  combobox=1 value=$smarty.post.query.to_hide}
	</dt>				
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InvoiceSupplier/list.tpl"}
</div> 