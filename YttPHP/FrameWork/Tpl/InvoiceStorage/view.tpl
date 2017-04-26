{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="100%">
	<tbody>      
    	<tr>
    		<td class="t_right" width="15%">{$lang.product_name}：</td>
    		<td class="t_left" width="20%">{$rs.product_name}</td>
    		{if 'invoice.product'|C==1}
    		<td class="t_right" width="15%">{$lang.product_no}：</td>
    		<td class="t_left"  >{$rs.product_no}</td>
    		{/if}
    	</tr>
    	<tr>
    		<th colspan="4">{$lang.init_storage_details}</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			{include file="InvoiceStorage/init_list.tpl"}
    		</td>
    	</tr>
    	<tr>
    		<th colspan="4">{$lang.in_details}</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			{include file='InvoiceStorage/in_list.tpl'}
    		</td>
    	</tr>
    	<tr>
    		<th colspan="4">{$lang.sale_details}</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			{include file='InvoiceStorage/sale_list.tpl'}
    		</td>
    	</tr>
    	{if 'invoice.invoice_return_show'|C==1}
    	<tr>
    		<th colspan="4">{$lang.return_details}</th>
    	</tr>	  	  	
    	<tr>
    		<td colspan="4">
    			{include file='InvoiceStorage/return_list.tpl'}
    		</td>
    	</tr>
    	{/if}
</table>
</div>