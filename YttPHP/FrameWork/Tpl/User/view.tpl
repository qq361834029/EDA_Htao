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
      <td>{$lang.user_name}：</td>
      <td class="t_left">{$rs.user_name}</td>      
    </tr>    
    <tr>
      <td>{$lang.real_name}：</td>
      <td class="t_left" id="td_user_name">{$rs.real_name}</td>      
    </tr>    
    <tr>
      <td>{$lang.belong_role}：</td>
      <td class="t_left">{$rs.role_name}</td>
    </tr>  
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
    {if $rs.user_type>1}
    <tr>
      <td>{if $rs.user_type==5|| $rs.user_type==6}{$lang.belongs_warehouse}{else}{$lang.belong_partner}{/if}：</td>
      <td class="t_left">{if $rs.logistics_id}{$rs.logistics_name}{elseif $rs.warehouse_id}{$rs.w_name}{else}{$rs.factory_name}{/if}</td>
    </tr>			
    {/if}
    <tr>
      <td>{$lang.user_ip}：</td>
      <td class="t_left">{$rs.user_ip}</td>
    </tr>
    <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left">{$rs.comments}</td>
    </tr>
    </tbody>
  </table> 
</div>