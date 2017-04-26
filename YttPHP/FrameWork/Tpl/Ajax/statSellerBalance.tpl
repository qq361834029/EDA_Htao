<div class="popHead"><div class="hTitle">{$lang.seller_balance}</div><div class="hClose">&nbsp;</div></div>
<div class="popBody" style="border-left:#90ACBA 1px solid;border-right:#90ACBA 1px solid;width:238px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td class="tbold" width=110 style="border-bottom:1px #CCCCCC dashed;">{$lang.available_balance}：</td>
		<td align="right" style="border-bottom:1px #CCCCCC dashed;"></td>
	</tr>
	{foreach from=$balanceResult  item=rs key=key}
		<tr>
			<td  style="border-bottom:1px #CCCCCC dashed;"></td>
			<td class="tbold" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;"  onclick="addTab('{"/ClientStat/view/basic_id/1/comp_id/`$login_user.company_id`/currency_id/{$rs.currency_id}"|U}','{$lang.funds_detail_list}',1); ">{$rs.currency_no}：<span class="t_right_red">{$rs.sum}</span></a></td>
		</tr>
	{/foreach}
	<tr>
		<td class="tbold" width=110 style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;"   onclick="addTab('{"/Recharge/index/confirm_state/0"|U}','{$lang.recharge_list}',1); ">{$lang.unavailable_balance}：</a></td>
		<td align="right" style="border-bottom:1px #CCCCCC dashed;"></td>
	</tr>
	{foreach from=$unBalanceResult  item=rs key=key}
		<tr>
			<td  style="border-bottom:1px #CCCCCC dashed;"></td>
			<td class="tbold" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;"  onclick="addTab('{"/Recharge/index/confirm_state/0"|U}','{$lang.recharge_list}',1); ">{$rs.currency_no}：<span class="t_right_red">{$rs.sum}</span></a></td>
		</tr>
	{/foreach}
</table>
</div>