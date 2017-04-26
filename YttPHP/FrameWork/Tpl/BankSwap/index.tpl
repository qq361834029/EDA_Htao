{wz}
<form method="POST" action="{'BankSwap/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
					<dt>
						<label>{$lang.out_swap_currency_name}：</label>
						{currency data=C('COMPANY_CURRENCY') name="query[out_currency_id]" id="out_currency_id" combobox=1}
	            	</dt> 
	            	<dt>
						<label>{$lang.in_swap_currency_name}：</label>
						{currency data=C('COMPANY_CURRENCY') name="query[in_currency_id]" id="in_currency_id" combobox=1}
	            	</dt>                     
					<dt>
						<label>{$lang.out_swap_account_name}：</label>
						<input type='hidden' name="query[out_bank_id]">
						<input type='text' url="{'/AutoComplete/bank'|U}" jqac>
	            	</dt> 
	            	<dt>
						<label>{$lang.in_swap_account_name}：</label>
						<input type='hidden' name="query[in_bank_id]">
						<input type='text' url="{'/AutoComplete/bank'|U}" jqac>
	            	</dt> 
					<dt>
					<label>{$lang.from_swap_date}：</label>
						<input type="text" name="date[from_delivery_date]" value="{$smarty.post.date.from_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="date[to_delivery_date]" value="{$smarty.post.date.to_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		</dt>                    
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="BankSwap/list.tpl"}
</div> 
