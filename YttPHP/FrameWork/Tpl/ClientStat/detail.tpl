<table  class="list" border="1"> 
	<tr>
		<th class="operate none" style="width:60px!important;"></th>
		<th rowspan="1">{$lang.money_date}</th> 
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<th rowspan="1">{$lang.warehouse_name}</th>{/if}
		<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.payables}{else}{$lang.should_paid}{/if}</th>
		<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.has_paid}{else}{$lang.have_paid}{/if}</th>  
		<th rowspan="1">{$lang.discount}</th> 
		<th rowspan="1">{$lang.funds}</th> 
		<th rowspan="1">{$lang.comments}</th> 
	</tr>
	{if $list.list}
	{foreach from=$list.list item=item key=key}
	<tr id="index_{$key}_{$item.object_id}"{if $item.sale_order_state!=3 && $item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}class="manual_finished"{/if} expand="1">
		{if $item.object_type==120}
			<td id="expand" class="operate t_center none" expand="1">
				<a href="javascript:;" onclick="$.showExpand('getClientStatSaleDetail','index_{$key}_{$item.object_id}','{$item.object_id}')">
					<span class="icon icon-pattern-plus"></span>
				</a>
			</td>
		{else}
			<td class="operate none">&nbsp;</td>
		{/if}
		<td>
			{$item.fmd_paid_date}
		</td>
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <td>
            {$item.w_name}
        </td>
        {/if}
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
		<td class="t_left">
			{if $item.comments_url}
				<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">{$item.edit_comments}</a>
			{else}
				{$item.edit_comments}
			{/if}
			{if $item.income_type>0 && $item.dml_use_paid<>'0.00'}
				<span class="red">({if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.actual_payment}{else}{$lang.actual_receipt}{/if}:{$item.dml_should_paid}，{$lang.allot_money}:{$item.dml_use_paid})</span>
			{/if}
		</td>
	</tr>
	{/foreach}
	<tr>
		<td class="operate t_center none"></td>
		<td class="red ">{if $smarty.get.show_type!='not_page'}{$lang.page_total}{else}{$lang.total}{/if}</td>        
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <td class="red "></td>
        {/if}
		<td class="red t_right"> {$list.total.dml_original_money} </td>
		<td class="red t_right"> {$list.total.dml_have_paid} </td>  
		<td class="red t_right"> {$list.total.dml_discount_money} </td>   
		<td class="red t_right"> {$list.total.dml_sum_need_paid} </td>    
		<td class="red ">&nbsp;</td>
	</tr>
	{if $smarty.get.show_type!='not_page'}
	<tr>
		<td class="operate t_center none"></td>
		<td class="red ">{$lang.total}</td>
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <td class="red "></td>
        {/if}
		<td class="red t_right"> {$list.all_total.dml_original_money}</td>
		<td class="red t_right"> {$list.all_total.dml_have_paid}</td>  
		<td class="red t_right"> {$list.all_total.dml_discount_money}</td>   
		<td class="red t_right"> {$list.all_total.dml_need_paid}</td>    
		<td class="red ">&nbsp;</td>
	</tr> 
	{/if}
	{else}
		<tr><td colspan="7">{$lang.no_record_for_search}</td></tr>
	{/if}
</table>
<br><br>
{if 'client_stat_sent_email'|C==1}
<script>
     var sent_email_url = '<a href="javascript:;" onclick="$.cancel(this)" url="{$uri}/sent_email/1"><dt><span class="icon icon-list-email"></span>{"sent_email"|L}</dt></a>';
     $dom.find(".note_right dl").append(sent_email_url);
</script>
{/if}