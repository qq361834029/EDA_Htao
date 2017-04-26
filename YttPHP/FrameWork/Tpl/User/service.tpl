<form action="{'User/updateService'|U}" method="POST" onsubmit="return false;">
{wz action="save,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}"/>
<input type="hidden" name="from_service" value="1"/>
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.user_name}：</td>
      <td class="t_left">{$rs.user_name}</td>      
    </tr>    
    <tr>
      <td>{$lang.real_name}：</td>
      <td class="t_left" id="td_user_name"> 
	 	<input type="text" name="real_name" id="real_name" value="{$rs.real_name}" class="spc_input" />__*__     
       	</td>      
    </tr>    
    
     <tr>
      <td>{$lang.state}：</td>
      <td class="t_left">
     	<input type="radio" name="to_hide" id="state" value="1" {if $rs.to_hide == 1} checked {/if}/>&nbsp;{$lang.open}
     	<input type="radio" name="to_hide" id="state" value="0" {if $rs.to_hide == 0} checked {/if}/>&nbsp;{$lang.close}
      	__*__
      </td>
    </tr> 
    <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left">
      	<textarea name="comments" id="comments">{$rs.edit_comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table>
</div>
</form>