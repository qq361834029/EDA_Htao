{wz}
<form method="POST" action="{"InvoiceProduct/index"|U}"  id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.product_name}：</label> 
			<input type="text" name="like[product_name]" url="{'AutoComplete/invoiceProductName'|U}" jqac />					
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
{include file="InvoiceProduct/list.tpl"}
</div> 