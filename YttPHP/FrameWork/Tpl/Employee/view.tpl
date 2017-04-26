{wz}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.employee_no}：</td>
			<td class="t_left">{$rs.employee_no}</td>
		</tr>
		<tr>
			<td>{$lang.employee_name}：</td>
			<td class="t_left">
				{$rs.employee_name}
			</td>
		</tr>
		<tr>
			<td>{$lang.sex}：</td>
			<td class="t_left">
				{if $rs.sex==1}{$lang.man}{else}{$lang.woman}{/if}
			</td>
		</tr>  	
		{company 
			type="tr" title=$lang.basic_name
			value=$rs.basic_name
			view=true
		}  
	    <tr>
	      <td>{$lang.phone}：</td>
	      <td class="t_left">{$rs.phone}</td>
	    </tr>	
	    <tr>
	      <td>{$lang.email}：</td>
	      <td class="t_left">{$rs.email}</td>
	    </tr>	
	    <tr>
	      <td>{$lang.entry_date}：</td>
	      <td class="t_left">
	      	{$rs.fmd_entry_date}
	      </td>
	    </tr>
	    <tr>
	      <td>{$lang.leave_date}：</td>
	      <td class="t_left">{$rs.fmd_leave_date}</td>
	    </tr>	
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left">{$rs.comments}</td>
		</tr>	        	        				
	</tbody>
</table>  
</div>
</form> 

