<table  class="list" border="1">
	<tr>
                <th class="operate none" style="width:60px!important;"></th>
		<th rowspan="1">{$lang.date}</th> 
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<th rowspan="1">{$lang.warehouse_name}</th>{/if}
		<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.payables}{else}{$lang.should_paid}{/if}</th>
		<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.has_paid}{else}{$lang.have_paid}{/if}</th> 
		<!--<th rowspan="1">{$lang.need_paid}</th> 
		<th rowspan="1">{$lang.use_paid}</th> -->
		<th rowspan="1">{$lang.discount}</th> 
		<th rowspan="1">{$lang.funds}</th> 
		<th rowspan="1">{$lang.comments}</th> 
	</tr> 
	{tr from=$list.list id="index_`$key`_`$item.object_id`" expand="1"}
                {if $item.object_type==120}
                    <td  id="expand" class="operate t_center none" expand="1">
                        <a href="javascript:;" onclick="$.showExpand('getClientStatSaleDetail','index_{$key}_{$item.object_id}','{$item.object_id}')">
                            <span class="icon icon-pattern-plus"></span>
                        </a>
                    </td>
                 {else}
                    <td class="operate none">&nbsp;</td>
                 {/if}
		{td}
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
		<!--{td}
			{$item.dml_need_paid}
		{/td} 
		{td}
			{$item.dml_use_paid}
		{/td} -->
		{td class="t_right"}
			{$item.dml_discount_money}
		{/td}
		{td class="t_right"}  
			{$item.dml_sum_need_paid}  
		{/td}
		{td total_link=false class="t_left"}
		
			{if $item.comments_url}
			<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$item.comments_url_title|default:$lang.view_detail}',1); ">
			{$item.edit_comments}
			</a>
			{else}
			{$item.edit_comments}
			{/if}
		{/td}
	{/tr}
	<tr>
        <td class="none"></td>
	<td class="red ">{$lang.page_total}</td>
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
    <td class="red "></td>
    {/if}
	<td class="red t_right"> {$list.total.dml_original_money} </td>
	<td class="red t_right"> {$list.total.dml_have_paid} </td> 
	<!--<td class="red "> {$list.total.dml_need_paid} </td>  
	<td class="red "> {$list.total.dml_use_paid} </td>  -->
	<td class="red t_right"> {$list.total.dml_discount_money} </td>   
	<td class="red t_right"> {$list.total.total_sum_need_paid} </td>    
	<td class="red ">&nbsp;</td>
	</tr> 
	<tr>
        <td class="none"></td>
	<td class="red ">{$lang.total}</td>
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <td class="red "></td>
    {/if}
	<td class="red t_right"> {$list.all_total.dml_original_money} </td>
	<td class="red t_right"> {$list.all_total.dml_have_paid} </td> 
	<!--<td class="red "> {$list.total.dml_need_paid} </td>  
	<td class="red "> {$list.total.dml_use_paid} </td>  -->
	<td class="red t_right"> {$list.all_total.dml_discount_money} </td>   
	<td class="red t_right"> {$list.all_total.dml_money} </td>    
	<td class="red ">&nbsp;</td>
	</tr> 
</table>
<br><br>