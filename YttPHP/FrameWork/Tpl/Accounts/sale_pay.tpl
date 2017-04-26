
</table> 
<div class="saletitle">{$lang.cash}</div>
<table border="0" cellspacing="0" cellpadding="0" class="sale_table" align="center">
	 <thead>
	 	<tr id="">
	 		<th width="150px">{$lang.affirm}</th>
	 		<th width="150px">{$lang.money}</th>
	 		<th width="150px">{$lang.account_money}</th>
	 		<th width="150px">{$lang.is_used}</th>
	 		<th width="150px">{$lang.is_no_used}</th>
	 		<th width="150px">{$lang.paid_date}</th>
	 		<th>{$lang.pay_comments}</th>
	 		
	 	</tr>
	 	{foreach item=item key=key from=$list.list}
	 		<tr id="{$item.id}">
	 		<td><input type="checkbox" name="check_info[]" value="{$item.paid_id}">{$item.paid_id}</td>
	 		<td>{$item.should_paid}({$item.income_type})</td>
	 		<td>{$item.dml_account_money}</td>
	 		<td>{$item.have_paid}</td>
	 		<td>{$item.need_paid}</td>
	 		<td>{$item.fmd_paid_date}</td>
	 		<td>{$item.comments}</td> 
	 		</tr>
 		{/foreach}	
	 </thead>
	 <tbody>
	 </tbody>
	</table>   
<!--<div class="saletitle">{$lang.pay_bill}</div>
<table border="0" cellspacing="0" cellpadding="0" class="sale_table" align="center">
	 <thead> 
 		<tr id="pay_bill_show">
	 		<th width="150px">{$lang.money}</th>
	 		<th width="150px">{$lang.paid_date}</th>
	 		<th width="150px">{$lang.account_money}</th>
	 		<th>{$lang.bill_no}</th>
	 		<th>{$lang.bill_date}</th>
	 		<th>{$lang.pay_comments}</th>
	 		<th>{$lang.operation}</th> 
	 	</tr>
	 	{foreach item=item key=key from=$funds.advance.bill}
	 		<tr id="bill{$item.id}">
	 		<td><input type="hidden" name="bill[{$item.id}][bill_no]" value="{$item.bank_center.bill_no}">{$item.bank_center.bill_no}</td>
	 		<td><input type="hidden" name="bill[{$item.id}][money]" value="{$item.dml_money}">{$item.dml_money}</td>
	 		<td><input type="hidden" name="bill[{$item.id}][account_money]" value="{$item.account_money}">{$item.dml_account_money}</td>
	 		<td><input type="hidden" name="bill[{$item.id}][bill_date]" value="{$item.bank_center.fmd_bank_date}">{$item.bank_center.fmd_bank_date}</td>
	 		<td><input type="hidden" name="bill[{$item.id}][paid_date]" value="{$item.fmd_paid_date}">{$item.fmd_paid_date}</td>
	 		<td><input type="hidden" name="bill[{$item.id}][comments]" value="{$item.comments}">{$item.comments}</td>
	 		<td><a href="javascript:;" onclick=delFund(this,"bill{$item.id}"); return false>{$lang.delete}</a></td>
	 		</tr>
 		{/foreach} 
	 </thead>
	 <tbody>
	 </tbody>
	</table>   
<div class="saletitle">{$lang.pay_transfer}</div>
 <table border="0" cellspacing="0" cellpadding="0" class="sale_table" align="center">
	 <thead> 
 		<tr id="pay_transfer_show">
	 		<th width="150px">{$lang.money}</th>
	 		<th width="150px">{$lang.paid_date}</th>
	 		<th width="150px">{$lang.account_money}</th> 
	 		<th>{$lang.pay_bank}</th>
	 		<th>{$lang.pay_comments}</th>
	 		<th>{$lang.operation}</th> 
	 	</tr>
	 	{foreach item=item key=key from=$funds.advance.transfer}
	 		<tr id="transfer{$item.id}"> 
	 		<td><input type="hidden" name="transfer[{$item.id}][bank_id]" value="{$item.bank_center.bank_id}">{$item.bank_center.dd_bank_id.account_name}</td>
	 		<td><input type="hidden" name="transfer[{$item.id}][money]" value="{$item.dml_money}">{$item.dml_money}</td>
	 		<td><input type="hidden" name="transfer[{$item.id}][account_money]" value="{$item.account_money}">{$item.dml_account_money}</td> 
	 		<td><input type="hidden" name="transfer[{$item.id}][paid_date]" value="{$item.fmd_paid_date}">{$item.fmd_paid_date}</td>
	 		<td><input type="hidden" name="transfer[{$item.id}][comments]" value="{$item.comments}">{$item.comments}</td>
	 		<td><a href="javascript:;" onclick=delFund(this,"transfer{$item.id}"); return false>{$lang.delete}</a></td>
	 		</tr>
 		{/foreach}  
	 </thead>
	 <tbody>
	 </tbody>
	</table>-->
	</td></tr>