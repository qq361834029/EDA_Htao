{wz}
<form method="POST" action="{"FundStat/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
	<dt>
		<label>{$lang.zh_name}：</label>
		<input type="hidden" name="query[bank_id]" value="{$smarty.post.query.bank_id}">
		<input type="text" name="bank" url="{'/AutoComplete/accountFundStat'|U}" jqac> 
	</dt>
	<dt>
		<label>{$lang.source}：</label>
		{select data=C('BANK_SOURCE') name="query[object_type]" value="`$smarty.post.query.object_type`"}
	</dt>
	{currency data=C('COMPANY_CURRENCY') name="query[currency_id]" id="currency_id" value=$rs.currency_id type='dt' title=$lang.currency_name}
	<dt>
		<label>{$lang.from_date}：</label>
		<input type="text" name="date[from_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()" value="{$smarty.post.date.from_paid_date}"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="date[to_paid_date]" class="Wdate spc_input_data" onClick="WdatePicker()" value="{$smarty.post.date.to_paid_date}"/>
	</dt>
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
<br>

{note}
<div id="print" class="width98">
{include file="FundStat/list.tpl"}
</div> 

