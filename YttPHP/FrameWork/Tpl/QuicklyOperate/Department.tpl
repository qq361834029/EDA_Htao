<form action="{'Department/insert'|U}" method="POST"  onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td class="width20">{$lang.department_no}：</td>
			<td class="t_left"><input type="text" name="department_no" value="{$max_no}" {$is_auto_no}>__*__</td>
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