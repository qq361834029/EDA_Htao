<form action="{'Lang/update'|U}" method="POST">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
	<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
			<tr>
				<td>{$lang.module}：</td>
				<td class="t_left">
					<input type="hidden" name="module" value="{$rs.module}">{$rs.module}
				</td>
			</tr>
			<tr> 
      			<td class="width10">{'SYSTEM_LANG.cn'|C}：</td>
      			<td class="t_left">
      				<input type="text" name="lang_value_cn" value="{$rs.lang_value_cn}" class="spc_input">
      			</td>
    		</tr>
    		<tr>
      			<td>{'SYSTEM_LANG.de'|C}：</td>
      			<td class="t_left"><input type="text" name="lang_value_de" value="{$rs.lang_value_de}" class="spc_input"/></td>
    		</tr>
		</tbody>
	</table> 
</div>
</form>