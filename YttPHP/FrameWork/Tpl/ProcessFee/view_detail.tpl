{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$lang.weight_interval,$lang.process_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		{$item.dml_weight_begin}&nbsp;{$lang.to}&nbsp;{$item.dml_weight_end}{C('WEIGHT_UNIT')}
	{/td}
	{td}
		{$item.dml_price}{$rs.currency_no}
	{/td}
	{detail_operation}
</tr>
{/detail_table}