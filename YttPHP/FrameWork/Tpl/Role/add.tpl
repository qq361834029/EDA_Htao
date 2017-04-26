<form method="POST" action="{'Role/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
         <tr><th colspan="8">{$lang.role_basic}</th></tr>
          <tr align="left">
            <td width="6%">{$lang.role_name}：</td>
            <td width="15%" class="t_left">
            	<input type="text" name="role_name" id="role_name" value=""  class="spc_input"/>__*__
            </td>
            {if $super_admin}
             <td width="6%">{$lang.admin}：</td>
            <td class="t_left">
            	<input type="radio" name="is_admin" id="is_admin" value="1" />{$lang.yes}
            	<input type="radio" name="is_admin" id="is_admin" value="0"  checked/>{$lang.no}__*__
            	({$lang.super_admin_visible})
            </td>
            {/if}           
      		<td width="8%">{$lang.role_type}：</td>
      		<td width="15%" class="t_left">
		  {select data=C('ROLE_TYPE') name="role_type" combobox=1 no_default=true} 
		</td>   
            <td width="6%">{$lang.role_comments}：</td>
            <td width="15%" class="t_left">
            	<input type="text" name="comment"  id="comment" value=""  class="spc_input"/>
            </td>
          </tr>    
          <tr><th colspan="8" class="t_left">{$lang.set_rights}</th></tr> 
          <tr><td colspan="8" align="left">
          {if 'rights_level'|C==2}
          {include file="Role/rights_2.tpl"}
          {elseif 'rights_level'|C==3}
          {include file="Role/rights_3.tpl"}
          {/if}
     </td></tr>                      
   </tbody>          
  </table>
</div>
</form>
