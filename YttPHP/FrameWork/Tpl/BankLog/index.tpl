{wz}
<form method="POST" action="{'BankLog/index'|U}" id="search_form">
__SEARCH_START__
<dl>
	{currency data=C('COMPANY_CURRENCY') name="query[currency_id]" id="currency_id" value=$rs.currency_id type='dt' title=$lang.currency_no}
	{if C('BANK_CASH')==2}
	<dt>
	      <label>{$lang.relevance_cash}：</label>
	      {select data=C('RELEVANCE_CASH') name="query[relevance_cash]" value="{$smarty.post.query.relevance_cash}"}
	</dt>
	{/if}
	<dt>
		<label>{$lang.from_date}：</label>
		<input type="text" name="date[from_delivery_date]" value="{$smarty.post.date.from_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
		<input type="text" name="date[to_delivery_date]" value="{$smarty.post.date.to_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
	</dt>
	<dt>
		<label>{$lang.bank_name}：</label>
		<input type='hidden' name="query[bank_id]" value="{$smarty.post.query.bank_id}">
		<input type='text' url="{'/AutoComplete/bank'|U}" jqac>
	</dt>
</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="BankLog/list.tpl"}
</div>