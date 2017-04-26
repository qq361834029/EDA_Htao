<form action="{'Basic/insert'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$info.id}" class="spc_input" >
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
      		<td class="width10">{$lang.basic_name}：</td>
      		<td class="t_left"><input type="text" name="basic_name" id="basic_name" value="{$info.basic_name}" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" value="{$info.tax_no}" class="spc_input"/></td>
    	</tr>
   		<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" class="spc_input" value="{$info.contact}" id="contact"></td>
    	</tr>
    	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="phone"  value="{$info.phone}" class="spc_input"/></td>
    	</tr>
    	<tr>
      		<td>{$lang.fax}：</td>
      		<td class="t_left"><input type="text" name="fax"  value="{$info.fax}" class="spc_input"/></td>
    	</tr>
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" value="{$info.email}" class="spc_input"/></td>
    	</tr>
     	<tr>
      		<td valign="top">{$lang.address}：</td>
      		<td class="t_left" valign="top"><textarea name="address" rows="5" cols="60">{$info.address}</textarea></td>
    	</tr>
	</tbody>
</table> 
</div>
</form>
