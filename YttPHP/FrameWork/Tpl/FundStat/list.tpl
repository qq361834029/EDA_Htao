<table  class="list" border="1"> 
	<tr>
		<th>{$lang.bank_name}</th> 
		<th>{$lang.currency_no}</th>
		<th>{$lang.bankremittanceandini}</th>
		<th>{$lang.bankjournal}</th>
		<th>{$lang.stat_advance_income_money}</th>
		<th>{$lang.client_funds}</th>
		<th>{$lang.factory_funds}</th>
		<th>{$lang.logistics_funds}</th>
		<th>{$lang.other_out_funds}</th>
		<th>{$lang.other_in_funds}</th>
		<th>{$lang.total}</th> 
	</tr> 
	
	{tr name="list" from=$list.list }
		{td class="t_left"}
			{$item.bank_name}
		{/td}
		{td }
			{$item.currency_no}
		{/td}
		{td class="red t_right" }
			<a href="javascript:;" onclick="addTab('{$item.bank_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_bank_money}
			</a>
		{/td}
		{td class="red t_right" }
			<a href="javascript:;" onclick="addTab('{$item.banklog_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_banklog_money}
			</a>
		{/td}
		{td class="red t_right"}
			<a href="javascript:;" onclick="addTab('{$item.advance_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_advance_money}
			</a>
		{/td}
		{td class="red t_right"}
			<a href="javascript:;" onclick="addTab('{$item.client_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_client_money}
			</a>
		{/td}
		{td class="green t_right" }
			<a href="javascript:;" onclick="addTab('{$item.factory_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_factory_money}
			</a>
		{/td}
		{td  class="green t_right" }
			<a href="javascript:;" onclick="addTab('{$item.logistics_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_logistics_money}
			</a>
		{/td}
		{td  class="green t_right" }
			<a href="javascript:;" onclick="addTab('{$item.other_out_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_other_out_money}
			</a>
		{/td}
		{td class="red t_right" }
			<a href="javascript:;" onclick="addTab('{$item.other_in_money_url}','{$lang.view_detail}',1); ">
			{$item.dml_other_in_money}
			</a>
		{/td}  
		{td class="t_right"}
			<a href="javascript:;" onclick="addTab('{$item.all_url}','{$lang.view_detail}',1); ">
			{$item.dml_money}
		{/td}  
	{/tr} 
	<tr> 
		<th colspan="1">{$lang.currency_no}</th> 
		<th colspan="4">{$lang.income_money}</th> 
		<th colspan="3">{$lang.outlay_money}</th>  
		<th colspan="3">{$lang.total}</th> 
	</tr>
	{tr name="total" from=$list.total_list.list }
		 
		{td }
			{$item.currency_no}
		{/td}
		{td colspan="4" class="t_right"}
			{$item.dml_income_money}
		{/td}
		{td colspan="3" class="t_right"}
			{$item.dml_outlay_money}
		{/td}
		{td colspan="3" class="t_right"}
			{$item.dml_money}
		{/td} 
	{/tr}  
	  
</table>
<br><br>