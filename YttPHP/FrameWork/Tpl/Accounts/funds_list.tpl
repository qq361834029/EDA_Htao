</table>
<div class="saletitle none" id="show_cash_list_tr">{$lang.cash}</div>
<table border="0" cellspacing="0"  id="show_cash_list_info" cellpadding="0" class="detail_list none" align="center" >
	 <thead>
	 	<tr id="pay_cash_show">
		 	{if $comp_currency_count!=1}
		 		<th width="150px">{$lang.currency}</th>
	 		{/if}
	 		<th width="150px">{$lang.money}</th> 
	 		<th width="150px">{$lang.account_money}</th>
	 		<th width="150px">{$lang.rate}</th>
	 		<th width="150px">{$lang.paid_date}</th>
	 		<th>{$lang.pay_comments}</th>
	 		<th>{$lang.operation}</th> 
	 	</tr> 
	 </thead>
	 <tbody>
	 </tbody>
	</table>   
	
<div class="saletitle none" id="show_bill_list_tr">{$lang.pay_bill}</div>
<table border="0" cellspacing="0"  id="show_bill_list_info" cellpadding="0" class="detail_list none" align="center">
	 <thead> 
 		<tr id="pay_bill_show">
 			{if $comp_currency_count!=1}
 				<th width="150px">{$lang.currency}</th>
 			{/if}
	 		<th width="150px">{$lang.money}</th>
	 		<th width="150px">{$lang.account_money}</th>
	 		<th width="150px">{$lang.rate}</th> 
	 		<th>{$lang.bill_no}</th>
	 		<th width="150px">{$lang.paid_date}</th> 
	 		<th>{$lang.bill_date}</th>
	 		<th>{$lang.pay_comments}</th>
	 		<th>{$lang.operation}</th> 
	 	</tr> 
	 </thead>
	 <tbody>
	 </tbody>
	</table>   
<div class="saletitle none" id="show_transfer_list_tr">{$lang.pay_transfer}</div>
 <table border="0" cellspacing="0" id="show_transfer_list_info" cellpadding="0" class="detail_list none" align="center">
	 <thead> 
 		<tr id="pay_transfer_show">
	 		<th>{$lang.pay_bank}</th>
	 		<th width="150px">{$lang.money}</th> 
	 		<th width="150px">{$lang.account_money}</th>
	 		<th width="150px">{$lang.rate}</th> 
	 		<th width="150px">{$lang.paid_date}</th> 
	 		<th>{$lang.pay_comments}</th>
	 		<th>{$lang.operation}</th> 
	 	</tr> 
	 </thead>
	 <tbody>
	 </tbody>
	</table>
	</td></tr>