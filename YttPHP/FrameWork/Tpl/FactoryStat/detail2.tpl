<table  class="list" border="1">  
	{foreach item=itemtr key=key from=$list.group_list}
	<tr>
	<td colspan="6" class="t_left">{$itemtr.0.title}</td> 
	</tr> 
	<tr>
		<th rowspan="1">{$lang.date}</th> 
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<th rowspan="1">{$lang.warehouse_name}</th>{/if}
		<th rowspan="1">{$lang.should_paid}</th>
		<th rowspan="1">{$lang.have_paid}</th>  
		<th rowspan="1">{$lang.discount}</th> 
		<th rowspan="1">{$lang.funds}</th> 
		<th rowspan="1">{$lang.comments}</th> 
	</tr>  
	{tr name="{$key}" from=$itemtr }
		{td }
			{$item.fmd_paid_date}
		{/td}
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        {td }
            {$item.w_name}
        {/td}
        {/if}
		{td class="t_right"}
			{$item.dml_original_money}
		{/td} 
		{td class="t_right"}
			{$item.dml_have_paid}
		{/td}  
		{td class="t_right"}
			{$item.dml_discount_money}
		{/td}
		{td class="t_right"}  
			{$item.dml_sum_need_paid}  
		{/td}
		{td class="t_left"}
			{if $item.comments_url}
			<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">
			{$item.edit_comments}
			</a>
			{else}
			{$item.edit_comments}
			{/if}
		{/td}
	{/tr}
	<tr>
	<td class="red ">{$lang.page_total}</td>
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<td class="red "></td>{/if}
	<td class="red t_right"> {$itemtr.0.total_original_money} </td>
	<td class="red t_right"> {$itemtr.0.total_have_paid} </td>
	<td class="red t_right"> {$itemtr.0.total_discount_money} </td>
	<td class="red t_right"> {$itemtr.0.total_sum_need_paid} </td>  
	<td class="red ">&nbsp;</td>
	</tr> 
	
	{/foreach }
	<tr>
	<td class="red ">{$lang.total}</td>
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<td class="red "></td>{/if}
	<td class="red t_right"> {$list.all_total.dml_original_money} </td>
	<td class="red t_right"> {$list.all_total.dml_have_paid} </td>
	<td class="red t_right"> {$list.all_total.dml_discount_money} </td>
	<td class="red t_right"> {$list.all_total.dml_money} </td>  
	<td class="red ">&nbsp;</td>
	</tr> 
	
</table>
<br><br>