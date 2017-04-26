<form action="{'GlsPrinterName/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
			<input type="hidden" name="id" id="id" value="{$rs.id}">
      		<td>{$lang.mac_address}：</td>
      		<td class="t_left">
				<input type="text" name="mac_address" class="spc_input disabled" value="{$rs.mac_address}" readonly>__*__
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.printer_name}：</td>
      		<td class="t_left">
				<input type="text" name="printer_name" value="{$rs.printer_name}" class="spc_input">__*__
      		</td>
    	</tr>
	</tbody>
</table>
</div>
</form>

