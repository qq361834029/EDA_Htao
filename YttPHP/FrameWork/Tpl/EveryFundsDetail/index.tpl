{wz}
<form method="POST" action="{"EveryFundsDetail/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
<dl>         			  
<dt>
	<label>{$lang.from_date}：</label>
	<input type="text" name="date[from_paid_date]" class="Wdate spc_input_data" id="from_paid_date" value="{$smarty.post.date.from_paid_date}" onClick="WdatePicker({literal}{minDate:'#F{$dp.$D(\'to_paid_date\',{d:-31});}'}{/literal})"/>
	<label>{$lang.to_date}</label>
	<input type="text" name="date[to_paid_date]" class="Wdate spc_input_data" id="to_paid_date" value="{$smarty.post.date.to_paid_date}" onclick="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'from_paid_date\',{d:31});}'}{/literal})"/>
</dt>
{currency data=C('COMPANY_CURRENCY') name="query[currency_id]" id="currency_id" value=$rs.currency_id type='dt' title=$lang.currency_no}
<dt>
	<label>{$lang.source}：</label>
	{select data=C('EVERY_FUNDS_DETAIL_SOURCE') name="query[object_type]" value="`$smarty.post.query.object_type`"}
</dt>
</dl>	
<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="EveryFundsDetail/list.tpl"}
</div> 

