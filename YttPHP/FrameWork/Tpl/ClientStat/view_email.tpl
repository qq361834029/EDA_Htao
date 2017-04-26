<div style="border: 1px solid #89A5C5;padding:5px 10px 10px 10px;margin:0 auto;height:auto;font-size:12px;">
<table cellspacing="0" cellpadding="0" style="font-size:12px;line-height:30px;border:1px solid #cccccc;" width="99%">  	
	<tr>
		<th>{$lang.client}“{$client_name}”，
			{if $smarty.get.type!=5}
				{$lang.currency}“{if $list.list.0.currency_no}{$list.list.0.currency_no}{elseif $list.debt.list.0.currency_no}{$list.debt.list.0.currency_no}{else}{$list.paid.list.0.currency_no}{/if}”{$lang.arrearage_details}
			{else}
			{if $smarty.get.relation_type==1} {$lang.unpaid_arrearage_details}
			{else if $smarty.get.relation_type==2} 
				{$lang.arrearage_details_afcloseout}
			{else} {$lang.all_arrearage_detail}
			{/if}
				{$lang.expand_sale_detail}
			{/if}
			{if 'delivery.show_delivery_status'|C==1 && 'sale.relation_sale_follow_up'|C==1}
				{$lang.comments}：<span style="background: #FFF7D1;">&nbsp;&nbsp;&nbsp;&nbsp;</span>{$lang.un_delivery_sale}
			{/if}
		</th>
	</tr>
	{if $smarty.request.for_type==2}
		<tr><td>{include file="ClientStat/detailForType2_email.tpl"}</td></tr>
	{else}
	<tr><td>{include file="ClientStat/detail2_email.tpl"}</td></tr>
	{/if}
</tbody>
</table>
</div>