{wz}
<form method="POST" action="{'RateError/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
				<dt>
					<label>{$lang.currency}：</label>
					<input type="hidden" name="query[from_currency_id]" id="from_currency_id">
					<input type="text" url="{'/AutoComplete/currency'|U}" jqac>
            	</dt> 
				<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_error_date]" value="{$smarty.post.date.from_error_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
            	</dt>   
            	<dt>
					<label>{$lang.to_date}：</label>
						<input type="text" name="date[to_error_date]" value="{$smarty.post.date.to_error_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
            	</dt>  
			</dl> 
__SEARCH_END__
</form> 
{note content="`$lang.rate_error`"}
<div id="print" class="width98">
{include file="RateError/list.tpl"}
</div> 