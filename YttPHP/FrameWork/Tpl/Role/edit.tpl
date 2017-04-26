<form method="POST" action="{'Role/update'|U}" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
         <tr><th colspan="8">{$lang.role_basic}</th></tr>
          <tr align="left">
            <td width="10%">{$lang.role_name}：</td>
            <td width="15%" class="t_left">
            	<input type="text" name="role_name" id="role_name" value="{$rs.role_name}" class="spc_input"/>__*__
            </td>
            {if $super_admin}
             <td width="8%">{$lang.admin}：</td>
            <td width="8%" class="t_left">
            	<input type="radio" name="is_admin" id="is_admin" value="1" {if $rs.is_admin==1}checked{/if}>{$lang.yes}
            	<input type="radio" name="is_admin" id="is_admin" value="0" {if $rs.is_admin==0}checked{/if}>{$lang.no}__*__
            </td>
            {/if}           
      		<td width="10%">{$lang.role_type}：</td>
      		<td width="20%" class="t_left"><select name="role_type" combobox>
		    <option value="1" {if $rs.role_type==1}selected{/if}>{$lang.full}</option>
		    <option value="{C('SELLER_ROLE_TYPE')}" {if $rs.role_type==C('SELLER_ROLE_TYPE')}selected{/if}>{$lang.seller}</option>
		    <option value="3" {if $rs.role_type==3}selected{/if}>{$lang.warehouse}</option>
		    <option value="4" {if $rs.role_type==4}selected{/if}>{$lang.partner}</option>
		  </select></td>   
            <td width="9%">{$lang.role_comments}：</td>
            <td width="10%" class="t_left">
            	<input type="text" name="comment"  id="comment" value="{$rs.comment}"  class="spc_input"/>
            </td>
          </tr>    
          {if $rs.is_admin!=1}
          <tr><th colspan="8" class="t_left">{$lang.set_rights}</th></tr> 
          <tr><td colspan="8" align="left">
          {if 'rights_level'|C==2}
          {include file="Role/rights_2.tpl"}
          {elseif 'rights_level'|C==3}
          {include file="Role/rights_3.tpl"}
          {/if}
          {/if}
     </td></tr>                      
   </tbody>          
  </table>
</div>
</form>