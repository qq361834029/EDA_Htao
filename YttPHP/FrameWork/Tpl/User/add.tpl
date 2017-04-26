<input type="hidden" id="url_5" value="{'/AutoComplete/warehouseName'|U}">
<input type="hidden" id="url_4" value="{'/AutoComplete/client'|U}">
<input type="hidden" id="url_2" value="{'/AutoComplete/factory'|U}">
<input type="hidden" id="role_url_5" value="{'/AutoComplete/warehouseRole'|U}">
<input type="hidden" id="role_url_4" value="{'/AutoComplete/partnerRole'|U}">
<input type="hidden" id="role_url_2" value="{'/AutoComplete/sellerRole'|U}">
<input type="hidden" id="role_url_1" value="{'/AutoComplete/companyRole'|U}">
<form method="POST" action="{'User/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr> 	 
      <td class="width10">{$lang.user_type}：</td>
      <td class="t_left"> 
        {if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
            {select name="user_type" id="user_type" onchange="javascript:setCompanyUrl(this.value);" data=C('CFG_WAREHOUSE_TYPE') combobox=1 initvalue=$login_user.user_type no_default=true}__*__
        {elseif $login_user.role_type==C('SELLER_ROLE_TYPE')}
            {select name="user_type" id="user_type" onchange="javascript:setCompanyUrl(this.value);" data=C('CFG_SELLER_STAFF_TYPE') combobox=1 initvalue=$login_user.user_type no_default=true}__*__ 
        {elseif $login_user.role_type==C('PARTNER_ROLE_TYPE')}
            {select name="user_type" id="user_type" onchange="javascript:setCompanyUrl(this.value);" data=C('CFG_PARTNER_TYPE') combobox=1 initvalue=$login_user.user_type no_default=true}__*__   
        {else}
            {select name="user_type" id="user_type" onchange="javascript:setCompanyUrl(this.value);" data=C('CFG_USER_TYPE') combobox=1 initvalue=$login_user.user_type no_default=true filter=2}__*__
        {/if}
       </td>
    </tr>
    <tr>
      <td>{$lang.user_name}：</td>
      <td class="t_left">
      	<input type="text" name="user_name" id="user_name" value="" class="spc_input" />__*__({$lang.email_user_name})       
      </td>   
    </tr>    
    <tr>
      <td>{$lang.real_name}：</td>
      <td class="t_left" id="td_user_name"> 
      <input type="text" id="employee_name" name="real_name" url="{'/AutoComplete/employee'|U}" jqac>
       	 {quicklyAdd module="Employee"}
       	
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
       <td>{$lang.belong_role}：</td>
       <td class="t_left">
        <input type="hidden" name="role_id" id="role_id"/>
        <input type="text" id="role" url="{'/AutoComplete/companyRole'|U}" jqac>__*__
       </td>
    </tr>          
    <tr id="company_tr" style="display:none">
      <td id="belong_name">{$lang.belong_partner}：</td>
      <td class="t_left">
        <input type="hidden" name="company_id" id="company_id">
        <input type="text" id="company" url="">__*__
      </td>
    </tr> 
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">
      	<input type="text" name="user_ip" id="user_ip" value="" class="spc_input" /> ({$lang.user_ip_separator})
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"> 
      	<textarea name="comments" id="comments">{$rs.comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
</div>
</form>
<script>
	$(document).ready(function(){
	    setCompanyUrl($dom.find('#user_type').val());
	});
</script>      