<table  class="list" border="1">  
	<tr>
		<th rowspan="1">{$lang.date}</th> 
		<th rowspan="1">{$lang.income_money}</th>
		<th rowspan="1">{$lang.outlay_money}</th>  
		<th rowspan="1">{$lang.balance}</th> 
		<th rowspan="1">{$lang.object_type}</th>
		{if $smarty.get.type != 'bank_money' && $smarty.get.type != 'banklog_money'}<th rowspan="1">{$lang.flow_no}</th>{/if}
		<th rowspan="1">{$lang.comments}</th> 
	</tr> 
	{tr from=$list.list}
		{td }
			{$item.fmd_paid_date}
		{/td}
		{td class="t_right"}
			{$item.dml_in_money}
		{/td} 
		{td class="t_right"}
			{$item.dml_out_money}
		{/td} 
		{td class="t_right"}
			{$item.dml_remaining_money}
		{/td}  
		{td total_link=false class="t_left"} 
			{$item.object_type_explain} 
		{/td}
		{if $smarty.get.type != 'bank_money' && $smarty.get.type != 'banklog_money'}
		{td total_link=false }
			{if $item.comments_url}
			<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">
			{$item.flow_no_explain}
			</a>
			{else}
			{$item.flow_no_explain}
			{/if}
		{/td}
		{/if}
		{td total_link=false class="t_left"} 
			{$item.new_comments} 
		{/td}
	{/tr}
	<tr>
	<td class="red">{$lang.page_total}</td> 
	<td class="red t_right"> {$list.total.dml_in_money} </td> 
	<td class="red t_right"> {$list.total.dml_out_money} </td>  
	<td class="red t_right"> {$list.total.total_remaining_money} </td>
	{if $smarty.get.type != 'bank_money' && $smarty.get.type != 'banklog_money'}
	<td class="red">&nbsp;</td>
	{/if}
	{if $smarty.get.type != 'bank_money'}<td class="red">&nbsp;</td>{/if}
	<td class="red">&nbsp;</td>
	</tr>
</table>