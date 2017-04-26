<table  class="list" border="1"> 
	<tr>
		<th>{$lang.date}</th> 
		<th>{$lang.client_name}</th>
		<th>{$lang.currency}</th>
		<th>{$lang.income_money}</th>
		<th>{$lang.outlay_money}</th>
		<th>{$lang.balance}</th>
		<th>{$lang.source}</th>
		<th>{$lang.comments}</th> 
	</tr>

	{tr name="before" from=$list.before class="red"} 
		{td class="t_center"}
			{$lang.stat_ini}
		{/td}
		{td }
			&nbsp;
		{/td}
		{td class="t_center"}
			{$item.currency_no}
		{/td}
		{td class="t_right"}
			{if $item.income_money!=0}
			{$item.dml_income_money}
			{/if}
		{/td}
		{td class="t_right"}
			{if $item.outlay_money!=0}
			{$item.dml_outlay_money}
			{/if}
		{/td}
		{td class="t_right"}
			{$item.dml_balance}
		{/td}
		{td class="t_right"}
			&nbsp;
		{/td}
		{td }
			&nbsp;
		{/td}  
	{/tr}
	
	{tr name="list" from=$list.list } 
		{td class="t_center"}
			{$item.fmd_paid_date}
		{/td}
		{td }
			{if $item.client_name}
			{$item.client_name}
			{/if}
			{if $item.bank_name}
			{$item.bank_name}
			{/if}
		{/td}
		{td class="t_center"}
			{$item.currency_no}
		{/td}
		{td class="t_right"}
			{if $item.income_money!=0}
			{$item.dml_income_money}
			{/if}
		{/td}
		{td class="t_right"}
			{if $item.outlay_money!=0}
			{$item.dml_outlay_money}
			{/if}
		{/td}
		{td class="t_right"}
			{$item.dml_balance}
		{/td}
		{td class="t_center"}
			{$item.object_type_explain}
		{/td}
		{td }
			{$item.edit_comments}
		{/td}  
	{/tr}

	{tr name="total" from=$list.total class="red"} 
		{td class="t_center"}
			{$lang.total}
		{/td}
		{td }
			&nbsp;
		{/td}
		{td class="t_center"}
			{$item.currency_no}
		{/td}
		{td class="t_right"}
			{if $item.income_money!=0}
			{$item.dml_income_money}
			{/if}
		{/td}
		{td class="t_right"}
			{if $item.outlay_money!=0}
			{$item.dml_outlay_money}
			{/if}
		{/td}
		{td class="t_right"}
			{$item.dml_balance}
		{/td}
		{td class="t_right"}
			&nbsp;
		{/td}
		{td }
			&nbsp;
		{/td}  
	{/tr}
</table>
<br><br>