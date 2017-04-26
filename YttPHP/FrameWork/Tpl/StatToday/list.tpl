<table  class="list" border="1"> 
	<tr>
		<th >{$lang.date}</th> 
		<th >{$lang.client_name}</th> 
		<th >{$lang.quantity}</th> 
		<th >{$lang.sum_capability}</th>
		<th >{$lang.currency}</th>
		<th >{$lang.sale_money}</th>
		<th >{$lang.income_money}</th>
		<th >{$lang.outlay_money}</th>
		<th >{$lang.flow_no}</th>
		<th >{$lang.comments}</th> 
	</tr> 
	
	{tr name="list" from=$list.list } 
		{td class="t_center"}
			{$item.fmd_paid_date}
		{/td}
		{td }
			{$item.client_name}
		{/td}
		{td class="t_right"}
			{if $item.quantity>0}
			{$item.dml_quantity}
			{/if}
		{/td}
		{td  class="t_right"}
			{if $item.capability>0}
			{$item.dml_capability}
			{/if}
		{/td}
		{td class="t_center"}
			{$item.currency_no}
		{/td}
		{td class="t_right"}
			{if $item.sale_money>0}
			{$item.dml_sale_money}
			{/if}
		{/td}
		{td class="t_right"}
			{if $item.income_money>0}
			{$item.dml_income_money}
			{/if}
		{/td}
		{td class="t_right"}
			{if $item.outlay_money>0}
			{$item.dml_outlay_money}
			{/if}
		{/td}
		{td class="t_center"}
			<a href="javascript:;" onclick="addTab('{$item.link}','{$lang.view_detail}',1); ">
			{$item.flow_no}
			</a>
		{/td}
		{td }
			{$item.edit_comments}
		{/td}  
	{/tr}
	{tr name="total" from=$list.total_list class="red"} 
		{td merge='total_id' title="{$lang.total}" colspan="2" class="t_right"}
			{$item.total}
		{/td}
		{td merge='total_id' class="t_right"}
			{$item.dml_quantity}
		{/td}
		{td merge='total_id' class="t_right"}
			{$item.dml_capability}
		{/td}
		{td class="t_center"}
			{$item.currency_no}
		{/td}
		{td class="t_right"}
			{$item.dml_sale_money}
		{/td}
		{td class="t_right"}
			{$item.dml_income_money}
		{/td}
		{td class="t_right"}
			{$item.dml_outlay_money}
		{/td}
		{td class="t_center"}
			{$item.flow_no}
		{/td}
		{td }
			{$item.comments}
		{/td}  
	{/tr} 
	  
	{if $list.before.list}
	{tr name="before" from=$list.before.list class="red"}
		{td colspan="4" merge='name_id'}
			{$item.name}
		{/td} 
		{td }
			{$item.currency_no}
		{/td} 
		{td colspan="5"}
			{$item.dml_money}
		{/td}  
	{/tr}
	{/if }
	 
	 {if $list.after.list}
	{tr name="after" from=$list.after.list class="red"}
		{td colspan="4" merge='name_id' }
			{$item.name}
		{/td} 
		{td }
			{$item.currency_no}
		{/td} 
		{td colspan="5"}
			{$item.dml_money}
		{/td}  
	{/tr}
	 {/if }
	
</table>
<br><br>