<table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center" id="show_cash_list_info" {if $rs.fund.advance.cash eq ""}  style="display:none"{/if}>
	 	{foreach item=item key=key from=$rs.fund.advance.cash}
	 		<tr id="cash{$item.id}">
	 		<td id="pay_cash_show" class="b_top t_right">{$lang.cash}：</td>
	 		<td width="121"  class="b_top t_right_red"><input type="hidden" id="money" name="cash[{$item.id}][money]" value="{$item.money}"><span class="pad_right_3">{$item.dml_money}</span></td>
	 		<td width="60"  class="b_top"><a href="javascript:;" onclick=delFund(this,"cash{$item.id}","cash"); return false>
	 		<span class="icon icon-del-plus"></span></a></td>
	 		</tr>
 		{/foreach}	
	</table>   
<table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center" id="show_bill_list_info" {if $rs.fund.advance.bill eq ""}  style="display:none"{/if}>
	 	{foreach item=item key=key from=$rs.fund.advance.bill}
	 		<tr id="bill{$item.id}">
	 		<td id="pay_bill_show" class="b_top t_right">{$lang.bill_date}：<input type="hidden" name="bill[{$item.id}][bill_date]" value="{$item.bank_center.fmd_bank_date}">{$item.bank_center.fmd_bank_date}&nbsp;&nbsp;&nbsp;{$lang.bill_no}：<input type="hidden" name="bill[{$item.id}][bill_no]" value="{$item.bank_center.bill_no}">{$item.bank_center.bill_no}&nbsp;&nbsp;&nbsp;{$lang.pay_bill}：</td>
	 		<td width="121" class="b_top t_right_red"><input type="hidden" name="bill[{$item.id}][money]" value="{$item.money}" id="money"><span class="pad_right_3">{$item.dml_money}</span></td>	
    		<td width="60" class="b_top"><a href="javascript:;" onclick=delFund(this,"bill{$item.id}","bill"); return false><span class="icon icon-del-plus"></span></a></td>
	 		</tr>
 		{/foreach} 
	</table>   
	
 <table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center" id="show_transfer_list_info" {if $rs.fund.advance.transfer eq ""}  style="display:none"{/if}>
	 	{foreach item=item key=key from=$rs.fund.advance.transfer}
	 	<tr id="transfer{$item.id}"> 
	 	    <td id="pay_transfer_show" class="b_top t_right">{$lang.pay_bank}:<input type="hidden" name="transfer[{$item.id}][bank_id]" value="{$item.bank_center.bank_id}">{$item.bank_center.bank_name}&nbsp;&nbsp;&nbsp;{$lang.pay_transfer}：</td>
	 		<td width="121" class="b_top t_right_red"><input type="hidden" name="transfer[{$item.id}][money]" value="{$item.money}" id="money"><span class="pad_right_3">{$item.dml_money}</span></td>
	 		<td width="60" class="b_top"><a href="javascript:;" onclick=delFund(this,"transfer{$item.id}","transfer"); return false><span class="icon icon-del-plus"></span></a></td>
	 		</tr>
 		{/foreach}  
	</table>
	