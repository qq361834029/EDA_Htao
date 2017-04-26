{assign var='currency' value=S('currency')}
<table class="list">
	<tr>
		<th class="slant_title_bg" valign="top" rowspan="2">
			<div style="text-indent:60px;">{$lang.currency}</div>
			<div>{$lang.quantity_and_price}</div>
			<div class="t_left pad_left_10">{$lang.date}</div>
		</th>
		{foreach from=$list.total.currency_id_sum item=item key=key}
			<th  colspan="2">{$currency[$key]['currency_no']}</th>
		{/foreach}
		{if $list.total.currency_id_sum|count==0}
			<th rowspan="2"></th>
		{/if}
	</tr>
	<tr>
	{foreach from=$list.total.currency_id_sum item=item key=key}
		<th>{$lang.sum_quantity}</th>
		<th>{$lang.price}</th>
	{/foreach}
	</tr>
	{foreach from=$list.list item=item1 key=key1}
	<tr>
		<td class="t_center">{$item1.order_date}</td>
		{foreach from=$list.total.currency_id_sum item=item2 key=key2}
			<td class="t_right">
			{if $item1.curr[$key2]!=0}
				<a href="javascript:;" onclick="addTab('{$item1.curr[$key2].detail_url}','{"clientDealAnalysisDetail"|title:"StatClientAnalysis"}',1)">
				{$item1.curr[$key2].dml_sum_quantity|default:0}
				</a>
			{else}
				{$item1.curr[$key2].dml_sum_quantity|default:0}
			{/if}
			</td>
			<td class="t_right">{$item1.curr[$key2].dml_avg_price|default:0}</td>
		{/foreach}
	</tr>
	{/foreach}
</table>