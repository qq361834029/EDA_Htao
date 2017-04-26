<form action="{"InvoiceSupplier/update"|U}" method="POST">
{wz action='save,list,reset'}
<div class="add_box">
<input type="hidden" name='comp_type' value='2'>
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    	<tr>
      		<td class="width10">{$lang.basic_name}：</td>
      		<td class="t_left"><input type="text" name="company_name" id="company_name" value="{$rs.company_name}">__*__</td>
    	</tr>
    	<tr>
      		<td>IVA：</td>
      		<td class="t_left"><input type="text" name="iva" id="iva" value="{$rs.iva}" >__*__</td>
    	</tr>    
    	<tr>
      		<td valign="top">{$lang.address}：</td>
      		<td class="t_left" valign="top"><textarea name="address" rows="5" cols="80">{$rs.address}</textarea></td>
    	</tr>
    	<tr>
    		<td valign="top">{$lang.comments}：</td>
    		<td class="t_left" valign="top"><textarea name="comments" row="5" cols="80">{$rs.comments}</textarea></td>
    	</tr>      
	</tbody>
</table> 
</div>
</form>
