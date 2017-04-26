<form action="{'Ajax/printBarcodeValid'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="module" value="{$smarty.get.module}" />
<div class="table_autoshow" style="border-style:none!important; width: 360px!important;">
{detail_table from=$rs action=['printBarcode'] op_show=false thead=[$lang.product_id,$lang.quantity] tfoot=false}
<tr index="{$index}" class="{$none}" class="t_left">
	{td type="product_id" id="span_id" class="t_left w120"}
		<input type="text" name="detail[{$index}][id]" id="id" value="{$item.id}"  class="disabled {if $index}valid-required{/if}" readonly/>
	{/td}
	{td class="t_right `$w_class`"}
        <input type="text" name="detail[{$index}][quantity]" style="width: 95%;" id="quantity" autocomplete="off" value="{$item.edml_quantity}" {if $index}class="valid-required"{/if} />
	{/td}
	{detail_operation}
</tr>
{/detail_table}
</div>
</form> 

