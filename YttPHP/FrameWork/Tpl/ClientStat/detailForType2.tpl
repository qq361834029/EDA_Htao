<div style="width:49%;float: left;">
	<table  class="list" border="1"  align="left" style="margin-bottom:10px !important;">
		<tr>
			<th colspan="7">{$lang.debt_info}</th>
		</tr>
		<tr>
			<th class="operate" style="width:60px!important;"></th>
			<th rowspan="1">{$lang.date}</th> 
			<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.payables}{else}{$lang.should_paid}{/if}</th> 
			<th rowspan="1">{$lang.comments}</th> 
		</tr>
		{foreach from=$list.debt.list item=item key=key}
			<tr id="index_{$key}_{$item.object_id}"{if $item.sale_order_state!=3 && $item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}class="manual_finished"{/if} expand="1">
				{if $item.object_type==120}
					<td id="expand" class="operate t_center" expand="1">
						<a href="javascript:;" onclick="$.showExpand('getClientStatSaleDetail','index_{$key}_{$item.object_id}','{$item.object_id}')">
							<span class="icon icon-pattern-plus"></span>
						</a>
					</td>
				{else}
					<td class="operate">&nbsp;</td>
				{/if}
				<td>
					{$item.fmd_paid_date}
				</td>
				<td class="t_right">
					{$item.dml_should_paid}
				</td> 
				<td class="t_left">
					{if $item.comments_url}
						<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">{$item.edit_comments}</a>
					{else}
						{$item.edit_comments}
					{/if}
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<div style="width:49%;float: right;">
	<table  class="list" border="1"  align="right" style="margin-bottom:10px !important;">
		<tr>
			<th colspan="6">{$lang.paid_info}</th>
		</tr>
		<tr>
			<th rowspan="1">{$lang.receipt_date}</th> 
			<th rowspan="1">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.has_paid}{else}{$lang.have_paid}{/if}</th>
			<th rowspan="1">{$lang.comments}</th> 
		</tr>
		{foreach from=$list.paid.list item=item key=key}
			<tr id="index_paid"{if $item.sale_order_state!=3 && $item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}class="manual_finished"{/if} expand="1">
				<td>
					{$item.fmd_paid_date}
				</td>
				<td class="t_right">
					{$item.dml_should_paid}
				</td>
				<td class="t_left">
					{if $item.comments_url}
						<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">{$item.edit_comments}</a>
					{else}
						{$item.edit_comments}
					{/if}
				</td>
			</tr>
		{/foreach}
	</table>
</div>
<br style="clear:both;"><br>
<table  class="list" border="1" style="width:60%;">
	<tr>
		<th>{$lang.total}</th>
		<td class="red t_left">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.payables}{else}{$lang.should_paid}{/if}：{$list.total.dml_should_paid}</td>
		<td class="red t_left">{if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$lang.has_paid}{else}{$lang.have_paid}{/if}：{$list.total.dml_have_paid}</td>
		<td class="red t_left">{$lang.funds}：{$list.total.dml_need_paid}</td>
	</tr>
</table>

<br><br>
{if 'client_stat_sent_email'|C==1}
<script>
     var sent_email_url = '<a href="javascript:;" onclick="$.cancel(this)" url="{$uri}/sent_email/1"><dt><span class="icon icon-list-email"></span>{"sent_email"|L}</dt></a>';
     $dom.find(".note_right dl").append(sent_email_url);
</script>
{/if}