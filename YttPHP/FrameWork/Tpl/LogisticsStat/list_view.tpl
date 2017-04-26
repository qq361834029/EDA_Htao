{if $smarty.request.for_type==2}
	{if $smarty.request.type>1}
	{include file="FactoryStat/detailForType`$smarty.request.type`.tpl"}
	{else} 
	{include file="FactoryStat/detailForType.tpl"}
	{/if}
{else}
	{if $smarty.request.type>1}
		{include file="FactoryStat/detail`$smarty.request.type`.tpl"}
	{else} 
		{include file="FactoryStat/detail.tpl"}
	{/if}
{/if}