{wz}
<form method="POST" action="{'BankRemittance/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
					<dt>
						<label>{$lang.out_remittance_account_name}：</label>
						<input type='hidden' name="out_bank_id">
						<input type='text' url="{'/AutoComplete/bank'|U}" jqac>
	            	</dt> 
	            	<dt>
						<label>{$lang.in_remittance_account_name}：</label>
						<input type='hidden' name="in_bank_id">
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
{include file="BankRemittance/list.tpl"}
</div> 
