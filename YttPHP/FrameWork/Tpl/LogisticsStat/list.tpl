<table  class="list" border="1">
	<tr>
		<th rowspan="1">{$lang.logistics_name}</th> 
		<th rowspan="1">{$lang.contact}</th> 
		<th rowspan="1">{$lang.mobile}</th> 
		<th rowspan="1">{$lang.email}</th>  
		<th rowspan="1">{$lang.currency_no}</th>
		{if 'instock.add'|C>=2}
		<th rowspan="1">{$lang.on_road_money}</th> 
		{/if}
		<th rowspan="1">{$lang.money}</th> 
	</tr> 
	{tr from=$list.list }
		{td class='t_left'}
			{$item.comp_name}
		{/td}
		{td class="t_left"}
			{$item.contact}
		{/td}
		{td class="t_left"}
			{$item.mobile}
		{/td}
		{td class="t_left"}
			{$item.email}
		{/td}
		{td }
			{$item.currency_no}
		{/td} 
		{if 'instock.add'|C>=2}
		{td class='t_right'}  
			{if $item.total_on_road>0}{$item.dml_total_on_road}{/if} 
		{/td}
		{/if}
		{td class='t_right'} 
			<a href="javascript:;" onclick="addTab('{$item.detail_url}','{$lang.view_detail}',1); ">
			{$item.dml_total_need_paid}
			</a>
		{/td}
	{/tr}
    {assign var=cols_num value=4}
    {if client_currency_count|C>1}
        {assign var=cols_num value=$cols_num+1}
    {/if}
    {if show_many_basic|C==1}
        {assign var=cols_num value=$cols_num+2}
    {/if}
	<tr class="red">
		<td class="t_right" colspan="{$cols_num}">{$lang.page_total}</td>
		{if 'instock.add'|C>=2}
		<td class='t_right'>{$list.total.total_currency_info_1}</td>
		{/if}
		<td class='t_right'>{$list.total.total_currency_info_0}</td>
	</tr>
	<tr class="red">
		<td class="t_right" colspan="{$cols_num}">{$lang.total}</td>
		{if 'instock.add'|C>=2}
		<td class='t_right'>{$list.page_total.total.total_currency_info_1}</td>
		{/if}
		<td class='t_right'>{$list.page_total.total.total_currency_info_0}</td>
	</tr>
</table>
<br><br>