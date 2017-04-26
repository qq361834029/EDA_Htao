<form action="{'Position/insert'|U}" method="POST"  onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td class="width20">{$lang.position_no}：</td>
			<td class="t_left"><input type="text" name="position_no" value="{$max_no}"  {$is_auto_no}>__*__</td>
		</tr>
		<tr>
			<td>{$lang.position_name}：</td>
			<td class="t_left">
				<input type="text" name="position_name" id="position_name" class="spc_input" >__*__
			</td>
		</tr> 
	</tbody>
</table> 
</div>
</form> 