{wz}
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>   
    	<tr>
      		<td class="width10">{$lang.invoiceproduct}：</td>
      		<td class="t_left">{$rs.product_name}</td>
    	</tr>   
    	{if C('invoice.product')} 
    	<tr>
      		<td>{$lang.product_no}：</td>
      		<td class="t_left">{$rs.product_no}</td>
    	</tr>    
    	{/if}
    	{if C('invoice.ingredient')==1}
    	<tr>
			<td>{$lang.invoice_ingredient}：</td>
			<td class="t_left">{$rs.ingredient}</td>
    	</tr>    
    	{/if}
    	<tr>
    		<th colspan="2">{$lang.set_product_connected}</th></tr>
    	<tr>
    		<td colspan="2" class="t_left">
    		{include file="InvoiceProduct/detail.tpl"}
    </td></tr>       
    </tbody>
  </table> 
