<input type="hidden" id="url_5" value="{'/AutoComplete/warehouseName'|U}">
<input type="hidden" id="url_4" value="{'/AutoComplete/client'|U}">
<input type="hidden" id="url_2" value="{'/AutoComplete/factory'|U}">
<input type="hidden" id="role_url_5" value="{'/AutoComplete/warehouseRole'|U}">
<input type="hidden" id="role_url_4" value="{'/AutoComplete/partnerRole'|U}">
<input type="hidden" id="role_url_2" value="{'/AutoComplete/sellerRole'|U}">
<input type="hidden" id="role_url_1" value="{'/AutoComplete/companyRole'|U}">
<form method="POST" action="{'User/update'|U}" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.user_type}：</td>
      <td class="t_left">
    {if $rs.user_type==2 || $admin_auth_key}
		<input type="hidden" name="user_type" id="user_type" value={$rs.user_type} />
		{$rs.dd_user_type}
    {elseif $login_user.role_type==C('SELLER_ROLE_TYPE')}
		<select name="user_type" combobox>
			<option value="3" >{$lang.seller_staff}</option>
		</select>__*__
    {elseif $login_user.role_type==C('PARTNER_ROLE_TYPE')}
		<select name="user_type" combobox>
			<option value="4" >{$lang.partner}</option>
		</select>__*__    
    {elseif $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
		<select name="user_type" combobox>
			<option value="5" >{$lang.warehouse}</option>
		</select>__*__
	{else}
		<select name="user_type" combobox onchange="javascript:setCompanyUrl(this.value);">
			<option value="1" {if $rs.user_type==1}selected{/if}>{$lang.company}</option>
			<!--option value="2" {if $rs.user_type==2}selected{/if}>{$lang.seller}</option-->
			<option value="3" {if $rs.user_type==3}selected{/if}>{$lang.seller_staff}</option>
			<option value="4" {if $rs.user_type==4}selected{/if}>{$lang.partner}</option>
			<option value="5" {if $rs.user_type==5}selected{/if}>{$lang.warehouse}</option>
		</select>__*__
	{/if}
      </td>
    </tr>
    <tr>
      <td>{$lang.user_name}：</td>
      <td class="t_left">
      	<input type="text" name="user_name" id="user_name" value="{$rs.user_name}" class="spc_input" />__*__({$lang.email_user_name})      
      </td>      
    </tr>    
    <tr>
      <td>{$lang.real_name}：</td>
      <td class="t_left" id="td_user_name"> 
	{if $rs.user_type==2}
		{$rs.real_name}
	{else}
		<input type="text" url="{'/AutoComplete/employee'|U}" id="employee_name" name="real_name" value="{$rs.real_name}" jqac>
		{quicklyAdd module="Employee"}
        {/if}
      </td>      
    </tr>    
    <tr>
      <td>{$lang.belong_role}：</td>
      <td class="t_left">
      <input type="hidden" name="role_id" id="role_id" value="{$rs.role_id}" />
      {if $rs.user_type==2 || $rs.user_type==3}
     	<input type="text" id="role" url="{'/AutoComplete/sellerRole'|U}" value="{$rs.role_name}" jqac>__*__
      {elseif $rs.user_type==4}
	<input type="text" id="role" url="{'/AutoComplete/partnerRole'|U}" value="{$rs.role_name}" jqac>__*__
      {elseif $rs.user_type==5}
	<input type="text" id="role" url="{'/AutoComplete/warehouseRole'|U}" value="{$rs.role_name}" jqac>__*__
      {else}
	<input type="text" id="role" url="{'/AutoComplete/companyRole'|U}" value="{$rs.role_name}" jqac>__*__
      {/if}
     </td>
    </tr>  
    {if $rs.user_type>1}
	{if $rs.user_type==2}
	    <tr id="company_tr">
	      <td id="belong_name">{$lang.belong_partner}：</td>
	      <td class="t_left">
	      <input type="hidden" name="company_id" id="company_id" value="{$rs.company_id}">
	      {if $rs.logistics_id}{$rs.logistics_name}{else}{$rs.factory_name}{/if}
	      </td>
	    </tr>
	 {else}
	    <tr id="company_tr">
	      <td id="belong_name">{if $rs.user_type==5}{$lang.belongs_warehouse}{else}{$lang.belong_partner}{/if}：</td>
	      <td class="t_left">
	      <input type="hidden" name="company_id" id="company_id" value="{$rs.company_id}">
	      <input type="text" id="company" 
	      {if $rs.user_type==5}
	      url="{'/AutoComplete/warehouseName'|U}"
	      {elseif $rs.user_type==4}
	      url="{'/AutoComplete/client'|U}"		  
	      {elseif $rs.user_type==3}
	      url="{'/AutoComplete/factory'|U}"
	      {/if} jqac 
	      value="{if $rs.logistics_id}{$rs.logistics_name}{elseif $rs.warehouse_id}{$rs.w_name}{else}{$rs.factory_name}{/if}">__*__
	      </td>
	    </tr>
	 {/if}
    {else}
	    <tr id="company_tr" style="display:none">
	      <td id="belong_name">{$lang.belong_partner}：</td>
	      <td class="t_left" id="company_tr_td">
	      <input type="hidden" name="company_id" id="company_id">
	      <input type="text" id="company" url="">__*__
	      </td>
	    </tr>
    {/if}
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">
      	<input type="text" name="user_ip" id="user_ip" value="{$rs.user_ip}" class="spc_input" /> ({$lang.user_ip_separator})
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