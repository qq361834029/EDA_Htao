<table  class="list" border="1"> 
	<tr>
		<th rowspan="1">{$lang.date}</th> 
		{if show_many_basic|C ==1}<th rowspan="1">{$lang.basic_name}</th>{/if}
		<th rowspan="1">{$lang.funds_class}</th>
		<th rowspan="1">{$lang.currency}</th>
		<th rowspan="1">{$lang.should_paid}</th>
		<th rowspan="1">{$lang.have_paid}</th>  
		<th rowspan="1">{$lang.discount}</th> 
		<th rowspan="1">{$lang.funds}</th> 
		<th rowspan="1">{$lang.operation}</th> 
	</tr>
	{foreach from=$list.list item=item key=key}
		<tr id="index_{$key}_{$item.object_id}" expand="1">
			<td>
				{$item.fmd_paid_date}
			</td>
			{if show_many_basic|C ==1}
			<td>
				{$item.basic_name}
			</td>				
			{/if}
			<td>
				{$item.pay_class_name}
			</td>
			<td class="t_right">
				{$item.currency_no}
			</td> 
			<td class="t_right">
				{$item.dml_original_money}
			</td> 			
			<td class="t_right">
				{$item.dml_have_paid}
			</td> 
			<td class="t_right">
				{$item.dml_discount_money}
			</td>
			<td class="t_right">  
				{$item.dml_sum_need_paid}  
			</td>
			<td>
				<span class="icon icon-list-view" url="{$item.url}" title="{title('view')}" onclick="addTab('{$item.url}','{title('view')}');"></span>
			</td>
		</tr>
	{foreachelse}
		<tr><td colspan="9">{$lang.no_record_for_search}</td></tr>
	{/foreach}
	{if $list.list}
		<tr class="red">
			<td class="t_right">{$lang.page_total}</td>
			{if show_many_basic|C ==1}
			<td>&nbsp;</td>
			{/if}
			<td>&nbsp;</td>
			<td class="t_right">&nbsp;</td>
			<td class="t_right">{$list.total.dml_original_money}</td>
			<td class="t_right">{$list.total.dml_have_paid}</td>
			<td class="t_right">{$list.total.dml_discount_money}</td>
			<td class="t_right">{$list.total.dml_sum_need_paid}</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="red">
			<td class="t_right">{$lang.total}</td>
			{if show_many_basic|C ==1}
			<td>&nbsp;</td>
			{/if}
			<td>&nbsp;</td>
			<td class="t_right">&nbsp;</td>
			<td class="t_right">{$list.all_total.dml_original_money}</td>
			<td class="t_right">{$list.all_total.dml_have_paid}</td>
			<td class="t_right">{$list.all_total.dml_discount_money}</td>
			<td class="t_right">{$list.all_total.dml_money}</td>
			<td>&nbsp;</td>
		</tr>
	{/if}
</table>