{wz}
<form method="POST" action="{"InvoiceCompany/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.basic_name}：</label>
			<input type="hidden" name="query[id]"> 
			<input type="text" name="company_name" url="{'AutoComplete/invoiceBasicName'|U}" jqac />					
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
{include file="InvoiceCompany/list.tpl"}
</div> 