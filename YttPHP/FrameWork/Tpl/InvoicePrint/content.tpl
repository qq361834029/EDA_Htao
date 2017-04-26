<table class="detail"  cellspacing="0" cellpadding="0" border="0" width="726">
	<tr>
		<th width="12%" height="24">Référence</th>
	    <th>Désigation</th>
	    <th width="12%">Quantité</th>
	    <th width="8%">P.U.HT</th>
	    {if $smarty.const.MODULE_NAME=='InvoiceOut'}
	    <th width="8%">%REM</th>
	    <th width="10%">Remise HT </th>
	    {/if}
	    <th width="12%">Montant HT </th>
	</tr>
	{foreach item=item from=$rs.detail}
	<tr>
	    <td height="22" class="t_left b_bottom">{$item.product_no}</td>
	    <td class="t_left b_bottom">{$item.product_name}</td>
	    <td class="b_bottom">{$item.dml_quantity}</td>
	    <td class="b_bottom">{$item.dml_price}</td>
	    {if $smarty.const.MODULE_NAME=='InvoiceOut'}
	    <td class="b_bottom">{$item.dml_discount}</td>
	    <td class="b_bottom">{$item.dml_pr_money}</td>
	    {/if}
	    <td class="b_bottom">{$item.dml_discount_money}</td>
	 </tr>
  	{/foreach}
  	<tr>
		<td class="t_left  "> </td>
		<td class="t_left "> </td>
		<td class=""> </td>
		<td class=""> </td>
		{if $smarty.const.MODULE_NAME=='InvoiceOut'}
		<td class=""> </td>
		<td class=""> </td>
		{/if}
		<td class=""> </td>
	</tr>
</table>
<script>
$(document).ready(function(){
	var rows	= $.cParseInt({$rs.detail|count})+1;
	var height	= 0;
	if(rows<24){
		height	= (24-rows)*22;
		$dom.find('.detail').find('tr:last').find('td').attr('height',height);
	}
});
</script>