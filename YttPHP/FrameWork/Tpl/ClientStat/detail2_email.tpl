<table cellspacing="0" cellpadding="0" style="width:100%;border:1px solid #cccccc;"> 
	<tr>
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.date}</th> 
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.should_paid}</th>
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.have_paid}</th>  
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.discount}</th> 
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.funds}</th> 
		<th style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.comments}</th> 
	</tr> 
	{foreach from=$list.list item=m_item key=key}
	<tr {if $m_item.sale_order_state!=3 && $m_item.object_type==120 && 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1} style="background: #FFF7D1;"{/if} expand="1">
		<td style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
			{$m_item.fmd_paid_date}
		</td>
		<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
			{$m_item.dml_original_money}
		</td> 
		<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
			{$m_item.dml_have_paid}
		</td>  
		<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
			{$m_item.dml_discount_money}
		</td>
		<td class="t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">  
			{$m_item.dml_sum_need_paid}  
		</td>
		<td class="t_left" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">
			{$m_item.edit_comments}
		</td>
	</tr>
	{if $m_item.sale_order_detail}
		<tr expandtr="true"><td class="t_center" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;"><span class="icon icon-pattern-open"></span></td><td colspan="5" style="border-top:1px solid #cccccc;white-space:nowrap;">{include file="AjaxExpand/getClientStatSaleDetail.tpl"}</td></tr>
	{/if}
	{/foreach}
	<tr>
	<td class="red" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{$lang.total}</td>
	<td class="red t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;"> {$list.total.dml_original_money} </td>
	<td class="red t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;"> {$list.total.dml_have_paid} </td>  
	<td class="red t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;"> {$list.total.dml_discount_money} </td>   
	<td class="red t_right" style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;"> {$list.total.total_sum_need_paid} </td>    
	<td class="red " style="border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;white-space:nowrap;">{if 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}{$lang.un_delivery_sale_money}：{$list.total.un_delivery_sale_money}{/if}</td>
	</tr>
</table>