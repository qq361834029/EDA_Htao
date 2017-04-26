<form action="{'OrderType/insert'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
      		<td>{$lang.order_type_name}：</td>
            <td class="t_left"><input type="text" name="order_type_name" value="{$info.order_type_name}" class="spc_input"/></td>
    	</tr>
     	<tr>
      		<td valign="top">{$lang.comment}：</td>
      		<td class="t_left" valign="top"><textarea name="comments" rows="5" cols="60">{$info.comments}</textarea></td>
    	</tr>
	</tbody>
</table> 
</div>
</form>
