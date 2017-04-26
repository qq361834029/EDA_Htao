{if $smarty.request.for_type==2}
	{if $smarty.request.type>1}
	{include file="WarehouseStat/detailForType`$smarty.request.type`.tpl"}
	{else} 
	{include file="WarehouseStat/detailForType.tpl"}
	{/if}
{else}
	{if $smarty.request.type>1}
		{include file="WarehouseStat/detail`$smarty.request.type`.tpl"}
	{else} 
		{include file="WarehouseStat/detail.tpl"}
	{/if}
{/if}