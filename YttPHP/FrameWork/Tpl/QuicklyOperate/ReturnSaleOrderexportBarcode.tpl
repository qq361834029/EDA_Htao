<form action="{'Ajax/exportBarcodeValid'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="module" value="{$smarty.get.module}" />
{if $smarty.get.type eq 'batch'}
{assign var='op_show' value=['exportBarcode']}
{assign var='w_class' value='w120'}
{else}
{assign var='op_show' value=false}
{assign var='w_class' value='w150'}
{assign var='disabled' value='disabled'}
{/if}
<div class="table_autoshow" style="border-style:none!important; width: 360px!important;">
{detail_table from=$rs action=['ReturnSaleOrderexportBarcode'] op_show=$op_show thead=[$lang.orderno,$lang.quantity] tfoot=false}
<tr index="{$index}" class="{$none}" class="t_left">
	{td type="product_id" id="span_id" class="t_left `$w_class`"}
		<input type="hidden" name="detail[{$index}][id]" id="id" value="{$item.id}"  {if $index}class="valid-required"{/if} />
		<input type="text" name="temp[{$index}][no]" value="{$item.no}" url="{'AutoComplete/returnOrderNo'|U}" jqac style="width: 95%;" {$disabled}>
	{/td}
	{td class="t_right `$w_class`"}
	<input type="text" name="detail[{$index}][quantity]" style="width: 95%;" id="quantity" autocomplete="off" value="{$item.edml_quantity}" {if $index}class="valid-required"{/if} />
	{/td}
	{detail_operation}
</tr>
{/detail_table}
</div>
</form> 

