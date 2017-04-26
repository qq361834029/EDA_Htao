<form method="POST" action="{'SellerStaff/update'|U}" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<input type="hidden" name="user_type" id="user_type" value="3" />
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td class="width10">{$lang.belongs_seller}：</td>
      <td class="t_left">
	  <input type="hidden" name="company_id" id="company_id" value="{$rs.company_id}">
	  <input type="text" id="company" value="{$rs.factory_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
      </td>
    </tr>
    {else}
	<input type="hidden" name="company_id" id="company_id" value="{$rs.company_id}">
    {/if}	 
    <tr>
      <td>{$lang.is_enable}：</td>
      <td class="t_left">
      	<select id="to_hide" name="to_hide" combobox>
		<option value="1" {if $rs.to_hide==1}selected{/if}>{$lang.yes}</option>
		<option value="2" {if $rs.to_hide==2}selected{/if}>{$lang.no}</option>
      	</select>__*__
      </td>      
    </tr>  
     <!--tr>
      <td>{$lang.use_usbkey}：</td>
      <td class="t_left">
      	<select name="use_usbkey" onchange="javascript:if(this.value==1){ $dom.find('#td_usekeylicens').show()}else{ $dom.find('#td_usekeylicens').hide();$dom.find('#usbkey').val('')}" combobox>
      	<option value="0" {if $rs.use_usbkey==0}selected{/if}>{$lang.no}</option>
      	<option value="1" {if $rs.use_usbkey==1}selected{/if}>{$lang.yes}</option>
      	</select>__*__
      </td>
    </tr>
     <tr id="td_usekeylicens" {if $rs.use_usbkey==0}style="display:none;"{/if}>
      <td>{$lang.use_usbkey_licens}：</td>
      <td class="t_left">
      	<input type="hidden" name="usbkey" id="usbkey" value="{$rs.usbkey}">
      	<input type="text" url="{'/AutoComplete/epass'|U}" where="{"id not in (select usbkey from user where to_hide=1 and id!={$rs.id})"|urlencode}" value="{$rs.epass_serial}" jqac> 
      	__*__
      </td>
    </tr-->
    <tr>
      <td>{$lang.email}：</td>
      <td class="t_left">
      	<input type="text" name="user_name" id="user_name" value="{$rs.user_name}" class="spc_input" />__*__      
      </td>      
    </tr>   
    <tr>
      <td>{$lang.employee_name}：</td>
      <td class="t_left">
      	<input type="text" name="real_name" id="real_name" value="{$rs.real_name}" class="spc_input" />      
      </td>      
    </tr>      
    <tr>
      <td>{$lang.role}：</td>
      <td class="t_left">
      	<input type="hidden" name="role_id" id="role_id" value="{$rs.role_id}" />
     	<input type="text" url="{'/AutoComplete/sellerRole'|U}" value="{$rs.role_name}" jqac>__*__
     </td>
    </tr>  
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">
      	<input type="text" name="user_ip" id="user_ip" value="{$rs.user_ip}" class="spc_input" /> ({$lang.user_ip_separator})
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left"> 
      	<textarea name="comments" id="comments">{$rs.edit_comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
</div>
</form>