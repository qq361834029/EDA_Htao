<form action="{"InvoiceCompany/update"|U}" method="POST" >
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" id="comp_type" value="1">  
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
    	<tr>
      		<td class="width10">{$lang.basic_name}：</td>
      		<td class="t_left"><input type="text" name="company_name" id="company_name" class="spc_input" value="{$rs.company_name}">__*__</td>
    	</tr> 
    	<tr>
    		<td>{$lang.tax_no}：</td>
    		<td class="t_left"><input type="text" name="tax_no" class="spc_input" value="{$rs.tax_no}" ></td>
    	</tr>   
	    <tr>
	      	<td valign="top">{$lang.address}：</td>
	      	<td class="t_left" valign="top"><textarea name="address" rows="5" cols="80">{$rs.edit_address}</textarea></td>
	    </tr>    
    	<tr>
	      	<td valign="top">{$lang.bank_account}：</td>
	      	<td class="t_left" valign="top"><textarea name="bank_account" rows="5" cols="80">{$rs.edit_bank_account}</textarea></td>
	    </tr>
     	<tr>
	      	<td>{$lang.register_fund}：</td>
	      	<td class="t_left"><input type="text" name="register_fund" class="spc_input" value="{if $rs.register_fund>0}{$rs.edml_register_fund}{/if}"/></td>
    	</tr>
    	<tr>
      		<td>{$lang.register_no}：</td>
      		<td class="t_left"><input type="text" name="register_no" value="{$rs.register_no}" class="spc_input"/></td>
    	</tr>
    	<tr>
      		<td>{$lang.comp_no}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$rs.comp_no}" class="spc_input"/></td>
    	</tr>    
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left"><textarea name="comments" rows="5" cols="80">{$rs.edit_comments}</textarea></td>
    	</tr>
    </tbody>
 </table> 
</div>
</form>
