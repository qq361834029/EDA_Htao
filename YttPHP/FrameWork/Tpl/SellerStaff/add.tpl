<form method="POST" action="{'SellerStaff/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="user_type" id="user_type" value="3" />
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td class="width10">{$lang.belongs_seller}：</td>
      <td class="t_left">
	  <input type="hidden" name="company_id" id="company_id" value="{$fac_id}">
	  <input id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
      </td>
    </tr>
    {else}
	<input type="hidden" name="company_id" id="company_id" value="{$fac_id}">
    {/if}		
     <!--tr>
      <td>{$lang.use_usbkey}：</td>
      <td class="t_left">
      	<select name="use_usbkey" onchange="javascript:if(this.value==1){ $dom.find('#td_usekeylicens').show()}else{ $dom.find('#td_usekeylicens').hide();$dom.find('#usbkey').val('')}" combobox>
      	<option value="0">{$lang.no}</option>
      	<option value="1">{$lang.yes}</option>
      	</select>__*__
      </td>
    </tr>
     <tr id="td_usekeylicens" style="display:none;">
      <td>{$lang.use_usbkey_licens}：</td>
      <td class="t_left">
      	<input type="hidden" name="usbkey" id="usbkey" value=""> 
      	<input type="text" url="{'/AutoComplete/epass'|U}" where="{"id not in (select usbkey from user where to_hide=1)"|urlencode}" jqac>
      	__*__
      </td>
    </tr-->
    <tr>
      <td>{$lang.email}：</td>
      <td class="t_left">
      	<input type="text" name="user_name" id="user_name" value="" class="spc_input" />__*__      
      </td>      
    </tr>   
    <tr>
      <td>{$lang.employee_name}：</td>
      <td class="t_left">
      	<input type="text" name="real_name" id="real_name" value="" class="spc_input" />      
      </td>      
    </tr>
    <tr>
      <td>{$lang.is_enable}：</td>
      <td class="t_left">
      	<select id="to_hide" name="to_hide" combobox>
		<option value="1">{$lang.yes}</option>
		<option value="2">{$lang.no}</option>
      	</select>__*__
      </td>      
    </tr> 
    <tr>
      <td>{$lang.user_password}：</td>
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
    <tr>
      <td>{$lang.role}：</td>
      <td class="t_left">
      	<input type="hidden" name="role_id" id="role_id" value="" />
     	<input type="text" url="{'/AutoComplete/sellerRole'|U}" jqac>__*__
     </td>
    </tr>  
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">
      	<input type="text" name="user_ip" id="user_ip" value="" class="spc_input" /> ({$lang.user_ip_separator})
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left"> 
      	<textarea name="comments" id="comments">{$rs.comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
</div>
</form>