{wz}
<form method="POST" action="{'RateInfo/index'|U}" id="search_form">
__SEARCH_START__
 <dl> 
					<dt>
						<label>{$lang.from_currency}：</label>
						<input type='hidden' name="query[from_currency_id]">
						<input type='text' url="{'/AutoComplete/currency'|U}" jqac>
	            	</dt>
	            	<dt>
						<label>{$lang.to_currency}：</label>
						<input type='hidden' name="query[to_currency_id]">
						<input type='text' url="{'/AutoComplete/currency'|U}" jqac>
	            	</dt> 
					<dt class="w320">
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_rate_date]" value="{$smarty.post.date.from_rate_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="date[to_rate_date]" value="{$smarty.post.date.to_rate_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="RateInfo/list.tpl"}
</div> 