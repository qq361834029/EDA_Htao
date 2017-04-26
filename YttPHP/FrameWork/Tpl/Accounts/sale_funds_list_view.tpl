{if $rs.fund.advance.cash || $rs.fund.advance.bill || $rs.fund.advance.transfer || $rs.fund.close_out.list.0.id>0}
 
{if $rs.fund.advance.cash}
    <table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center">
	 <thead>
	  	{foreach item=item key=key from=$rs.fund.advance.cash}
	 	<tr>
	 		<td  id="pay_cash_show" class="b_top t_right">{$lang.cash}：</td>
	 		<td  id="cash{$item.id}" class="t_right_red b_top" width="121"><span class="pad_right_3">{$item.dml_money}</span></td>
	 		</tr>
 		{/foreach}	
	 </thead>
	</table>   	
{/if}
{if $rs.fund.advance.bill}
	 <table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center">
	 	{foreach item=item key=key from=$rs.fund.advance.bill}
	 		<tr id="cash{$item.id}">
	 		<td id="pay_bill_show" class="b_top t_right">
	 		{$lang.bill_date}：{$item.bank_center.fmd_bank_date}&nbsp;
	 		{$lang.bill_no}：{$item.bank_center.bill_no}&nbsp;
	 		{$lang.pay_bill}：
	 		</td> 		
	 		<td class="t_right_red b_top" width="121"><span class="pad_right_3">{$item.dml_money}</span></td>
	 		</tr>
 		{/foreach} 
	</table>   	
{/if}
{if $rs.fund.advance.transfer}
	 <table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center">
	 	{foreach item=item key=key from=$rs.fund.advance.transfer}
	   <tr id="cash{$item.id}"> 
	 		<td id="pay_transfer_show" class="b_top t_right">
	 		{$lang.pay_bank}：{$item.bank_center.bank_name}&nbsp;&nbsp;&nbsp;{$lang.pay_transfer}：</td>
	 		<td class="t_right_red b_top" width="121"><span class="pad_right_3">{$item.dml_money}</span></td>
	 		</tr>
 		{/foreach}  
	</table>   	
{/if}

{if $rs.fund.close_out.list.0.id>0}
 <table border="0" cellspacing="0" cellpadding="0" class="add_table_money" align="center">
<tr>
	<th colspan="4">{$lang.else}</th>
</tr>
<tr>
	<td>{$lang.is_close_out}：</td>
	<td class="t_left">{$lang.yes}</td> 
	<td>{$lang.close_out_comments}：</td>
	<td class="t_left">
		{$rs.fund.close_out.list.0.comments}
	</td>    			
</tr>
</table>
{/if}




{/if}