<form action="{'Employee/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.employee_no}：</td>
			<td class="t_left"><input type="text" name="employee_no" value="{$rs.employee_no}"  {$is_auto_no}>__*__</td>
		</tr>
		<tr>
			<td>{$lang.employee_name}：</td>
			<td class="t_left">
				<input type="text" name="employee_name" id="employee_name" value="{$rs.employee_name}" class="spc_input" >__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.sex}：</td>
			<td class="t_left">
				<input type="radio" name="sex"   checked value="1"/>{$lang.man}
				<input type="radio" name="sex"   {if $rs.sex==2} checked{/if} value="2"/>{$lang.woman} __*__
			</td>
		</tr>  	
		{company
			type="tr" id="basic_name" name="basic_name" value=$rs.basic_name title=$lang.basic_name
			hidden=["id"=>"basic_id","name"=>"basic_id","value"=>$rs.basic_id]
		}  
	    <tr>
	      <td>{$lang.phone}：</td>
	      <td class="t_left"><input type="text" name="phone"  value="{$rs.phone}" class="spc_input"/></td>
	    </tr>	
	    <tr>
	      <td>{$lang.email}：</td>
	      <td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input"/></td>
	    </tr>	
	    <tr>
	      <td>{$lang.entry_date}：</td>
	      <td class="t_left">
	      	<input type="text" name="entry_date" value="{$rs.fmd_entry_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
	      </td>
	    </tr>
	    <tr>
	      <td>{$lang.leave_date}：</td>
	      <td class="t_left"><input type="text" name="leave_date" value="{$rs.fmd_leave_date}" class="Wdate spc_input" onClick="WdatePicker()" /></td>
	    </tr>	
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60">{$rs.edit_comments}</textarea></td>
		</tr>	        	        				
	</tbody>
</table>  
</div>
</form> 

