<script>
	$(document).ready(function(){
		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$dom.find('#mac_address'));
	});
</script>
<form action="{'GlsPrinterName/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table" align="center">
    <tbody>
		<tr>
      		<td>{$lang.mac_address}：</td>
      		<td class="t_left">
			<input type="text" name="mac_address" id="mac_address" value="" class="spc_input">__*__
      		</td>
    	</tr>
		<tr>
      		<td >{$lang.printer_name}：</td>
      		<td class="t_left">
      			<input type="text" name="printer_name" value="" class="spc_input">__*__
      		</td>
    	</tr>
	</tbody>
</table>
</div>
</form>