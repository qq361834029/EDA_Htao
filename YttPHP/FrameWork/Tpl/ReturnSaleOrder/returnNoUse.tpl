{wz}
<form method="POST" action="{"ReturnSaleOrder/returnNoUse"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.product_no}：</label>
			<input type="hidden" name="query[product_id]" id="id">
			<input type="text" name="product_no" url="{'AutoComplete/product'|U}" jqac >
		</dt>  
	</dl>
__SEARCH_END__
</form>
{note tabs="returnSaleOrder"}
<div id="print" class="width98">
{include file="ReturnSaleOrder/noUseList.tpl"}
</div> 