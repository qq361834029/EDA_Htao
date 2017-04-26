{wz}
<form method="POST" action="{'BankIni/index'|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.fund_type}：</label>
			{select data=C('FUND_TYPE') name='query[paid_type]' id='paid_type' value="`$smarty.post.query.paid_type`"}
		</dt>
		{currency data=C('COMPANY_CURRENCY') name="query[currency_id]" id="currency_id" value=$smarty.post.query.currency_id type='dt' title=$lang.currency_no}
		<dt>
			<label>{$lang.bank_name}：</label>
			<input type='hidden' name="query[bank_id]">
			<input type='text' url="{'/AutoComplete/bank'|U}" jqac>
		</dt> 
		<dt>
			<label>{$lang.from_date}：</label>
			<input type="text" name="date[from_delivery_date]" value="{$smarty.post.date.from_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="date[to_delivery_date]" value="{$smarty.post.date.to_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt> 
	</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="BankIni/list.tpl"}
</div> 
