<div style="width:49%;float: left;">
	<table  class="list" border="1"  align="left" style="margin-bottom:10px !important;">
		<tr>
			<td class="t_center" colspan="7" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.debt_info}</td>
		</tr>
		<tr>
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.date}</td> 
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.should_paid}</td> 
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.comments}</td> 
		</tr>
		{foreach from=$list.debt.list item=item key=key}
			<tr id="index_{$key}_{$item.object_id}"{if $item.sale_order_state!=3 && $item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}class="manual_finished"{/if} expand="1">
				<td style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
					{$item.fmd_paid_date}
				</td>
				<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
					{$item.dml_should_paid}
				</td> 
				<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
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
			<td class="t_center" colspan="6" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.paid_info}</td>
		</tr>
		<tr>
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.receipt_date}</td> 
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.have_paid}</td>
			<td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.comments}</td> 
		</tr>
		{foreach from=$list.paid.list item=item key=key}
			<tr id="index_{$key}_{$item.object_id}"{if $item.sale_order_state!=3 && $item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}class="manual_finished"{/if} expand="1">
				<td style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
					{$item.fmd_paid_date}
				</td>
				<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
					{$item.dml_should_paid}
				</td>
				<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
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
<table  class="list" border="1" style="width:60%;">
	<tr>
		<td style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.total}</td>
		<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.should_paid}：{$list.total.dml_should_paid}</td>
		<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.have_paid}：{$list.total.dml_have_paid}</td>
		<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.funds}：{$list.total.dml_need_paid}</td>
	</tr>
</table>
