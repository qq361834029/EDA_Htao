<form action="{"InvoiceProduct/update"|U}" method="POST">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>   
    	{if C('invoice.product')==1} 
    	<tr>
      		<td>{$lang.product_no}：</td>
      		<td class="t_left"><input type="text" name="product_no" class="spc_input" value="{$rs.product_no}">{if C('invoice.product')==1&&C('invoice.product_unique')==1}__*__{/if}</td>
    	</tr>    
    	{/if}
    	<tr>
      		<td class="width10">{$lang.product_name}：</td>
      		<td class="t_left"><input type="text" name="product_name" class="spc_input" value="{$rs.product_name}">__*__</td>
    	</tr>   
    	{if C('invoice.ingredient')==1}
    	<tr>
			<td>{$lang.invoice_ingredient}：</td>
			<td class="t_left"><input type="text" name="ingredient" id="ingredient" class="spc_input" value="{$rs.ingredient}"></td>
    	</tr>    
    	{/if}
    	<tr>
    		<th colspan="2">{$lang.set_product_connected}</th></tr>
    	<tr>
    		<td colspan="2" class="t_left">
    		{include file="InvoiceProduct/detail.tpl"}
    		</td>
    	</tr>       
    </tbody>
  </table> 
</div>
</form>
