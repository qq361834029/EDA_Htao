<form action="{'Position/insert'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.position_no}：</td>
			<td class="t_left"><input type="text" name="position_no" value="{$max_no}" {if $is_auto_no} readonly class="spc_input disabled" {else} class="spc_input" {/if}/>__*__</td>
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