{wz}
<form method="POST" action="{'StatSaleRate/index'|U}" id="search_form">
__SEARCH_START__
<dl>
	<dt>
		<label>{$lang.product_no}：</label>
		<input type="hidden" name='query[e.product_id]'>
		<input type='text' name="product_no" url="{'AutoComplete/product'|U}" jqac />
	</dt>
	<dt class="320">
		<label>{$lang.from_date}：</label>
		<input type="text" name="date[from_in_date]" class="Wdate spc_input_data" onclick="WdatePicker()">
		<label>{$lang.to_date}</label>
		<input type="text" name="date[to_in_date]" class="Wdate spc_input_data" onclick="WdatePicker()">
	</dt>
</dl>
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="StatSaleRate/list.tpl"}
</div>