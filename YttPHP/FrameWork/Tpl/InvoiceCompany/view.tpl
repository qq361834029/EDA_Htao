{wz}
<div class="add_box">
<input type="hidden" name="comp_type" id="comp_type" value="1">  
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
    	<tr>
      		<td class="width10">{$lang.basic_name}：</td>
      		<td class="t_left">{$rs.company_name}</td>
    	</tr>   
    	<tr>
    		<td>{$lang.tax_no}：</td>
    		<td class="t_left">{$rs.tax_no}</td>
    	</tr> 
	    <tr>
	      	<td valign="top">{$lang.address}：</td>
	      	<td class="t_left" valign="top">{$rs.address}</td>
	    </tr>    
    	<tr>
	      	<td valign="top">{$lang.bank_account}：</td>
	      	<td class="t_left" valign="top">{$rs.bank_account}</td>
	    </tr>
     	<tr>
	      	<td>{$lang.register_fund}：</td>
	      	<td class="t_left">{if $rs.register_fund>0}{$rs.edml_register_fund}{/if}</td>
    	</tr>
    	<tr>
      		<td>{$lang.register_no}：</td>
      		<td class="t_left">{$rs.register_no}</td>
    	</tr>
    	<tr>
      		<td>{$lang.comp_no}：</td>
      		<td class="t_left">{$rs.comp_no}</td>
    	</tr>    
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left">{$rs.comments}</td>
    	</tr>
    </tbody>
 </table> 
</div>
