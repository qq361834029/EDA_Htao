{wz}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.user_type}：</td>
      <td class="t_left">{$rs.dd_user_type}
      </td>
    </tr>   
    <tr>
      <td>{$lang.email}：</td>
      <td class="t_left">{$rs.user_name}</td>      
    </tr>    
    <tr>
      <td>{$lang.employee_name}：</td>
      <td class="t_left">{$rs.real_name}</td>      
    </tr>       
    <tr>
	<td>{$lang.is_enable}：</td>
	<td class="t_left">
		{if $rs.to_hide==1}
		{$lang.yes}
		{/if}
		{if $rs.to_hide==2}
		{$lang.no}
		{/if}
	</td>      
	</tr>  
    <tr>
      <td>{$lang.role}：</td>
      <td class="t_left">{$rs.role_name}</td>
    </tr>  
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left">{$rs.factory_name}</td>
    </tr>
    {/if}
    {if C('AUDITOR_ORDERS') || C('AUDITOR_LOADCONTAINER') || C('AUDITOR_SALEORDER') || C('AUDITOR_PREDELIVERY')}
    <tr>
      <td>{$lang.doc_audit}：</td>
      <td class="t_left">      	
     	<select name="use_usbkey">
      	<option value="1">{$lang.yes}</option>
      	<option value="0">{$lang.no}</option>
      	</select>__*__
     </td>
    </tr> 
    {/if}
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">{$rs.user_ip}</td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left">{$rs.comments}</td>
    </tr>
    </tbody>
  </table> 
</div>