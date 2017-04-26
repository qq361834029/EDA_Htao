{if $rs.transport_type==C('SEA_TRANSPORT')}
{assign var=interval value=$lang.volume_interval}
{else}
{assign var=interval value=$lang.weight_interval}
{/if}
{detail_table flow='sale' from=$rs.detail action=['view'] op_show=['add','edit']
	thead=[$interval,$lang.delivery_fee]}
<tr index="{$index}" class="{$none}" >
	{td}
		{$item.dml_weight_begin}&nbsp;{$lang.to}&nbsp;{$item.dml_weight_end}{($rs.transport_type==C('SEA_TRANSPORT'))|a2bc:C('VOLUME_SIZE_UNIT'):C('WEIGHT_UNIT')}
	{/td}
	{td}
		{$item.dml_price}{$rs.currency_no}
	{/td}
	{detail_operation}
</tr>
{/detail_table}