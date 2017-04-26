<form method="POST" action="{'User/resetPasswd'|U}" onsubmit="return false">
{wz action="save,reset"}
<input type="hidden" name="id" value="{$rs.id}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.user_name}：</td>
       <td class="t_left"> 
       		{$rs.user_name}  
       		<input type="hidden" name="user_name" id="user_name" value="{$rs.user_name}" />   
      </td>
    </tr>
    <tr>
      <td>{$lang.user_new_password}：</td>
      	<td class="t_left"> 
     		<input type="password" name="user_password" id="user_password" value="" class="spc_input" />__*__
     	</td>
    </tr>
    <tr>
      <td>{$lang.user_confirm_password}：</td>
      <td class="t_left"> 
     		<input type="password" name="user_password_confirm" id="user_password_confirm" value="" class="spc_input" />__*__
     </td>
    </tr>
    </tbody>
  </table>  
</div>
</form>