<form action="{"InvoiceClient/update"|U}" method="POST" name="Invoice_addInvoiceClient">
{wz action='save,list,reset'}
<div class="add_box">
<input type="hidden" name='comp_type' value='3'>
<input type="hidden" name='id' value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    	<tr>
      		<td class="width10">{$lang.client_name}：</td>
      		<td class="t_left"><input type="text" name="company_name" id="company_name" class="spc_input" value="{$rs.company_name}" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.basic_client}：</td>
      		<td class="t_left">
      			<input type="hidden" name="connect_client" id="connect_client" value="{$rs.connect_client}">
      			<input type="text" name="conn_comp_name" url="{'AutoComplete/client'|U}" jqac value="{$rs.client_name}"/>
      		</td>
    	</tr> 
    	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" id="tax_no" class="spc_input" value="{$rs.tax_no}" >__*__</td>
    	</tr>  
    	<tr>
      		<td>IVA：</td>
      		<td class="t_left"><input type="text" name="iva" id="iva" class="spc_input" value="{$rs.edml_iva}">__*__</td>
    	</tr>    
    	<tr>
      		<td valign="top">{$lang.address}：</td>
      		<td class="t_left" valign="top"><textarea name="address" rows="5" cols="80">{$rs.address}</textarea></td>
    	</tr>      
	</tbody>
</table> 
</div>
</form>
