<form action="{'Department/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.department_no}：</td>
			<td class="t_left"><input type="text" name="department_no" value="{$rs.department_no}" {$is_auto_no}>__*__</td>
		</tr>
		<tr>
			<td>{$lang.department_name}：</td>
			<td class="t_left">
				<input type="text" name="department_name" id="department_name" value="{$rs.department_name}" class="spc_input" >__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.address}：</td>
			<td class="t_left"><input type="text" name="address" value="{$rs.address}" class="spc_input"/></td>
		</tr> 
		</tbody>
	</table>  
</div>
</form> 

