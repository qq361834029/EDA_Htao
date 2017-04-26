<form action="{'Properties/update'|U}" method="POST" name="Basic_addProperties" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table"> 
 <tbody>
    <input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
     <tr>
      <td class="width10">{$lang.properties_no}：</td>
      <td class="t_left"><input type="text" name="properties_no" value="{$rs.properties_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_name}：</td>
      <td class="t_left">
      <input type="text" name="properties_name" class="spc_input" value="{$rs.properties_name}">__*__（{'SYSTEM_LANG.cn'|C}）
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_name}：</td>
      <td class="t_left">
      <input type="text" name="properties_name_de" class="spc_input" value="{$rs.properties_name_de}">__*__（{'SYSTEM_LANG.de'|C}）
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_type}：</td>
      <td class="t_left">{radio data=C('PROPERTIES_TYPE') name="properties_type" value=$rs.properties_type}</td>
    </tr>
    <tr>
      <td>{$lang.role_type}：</td>
      <td class="t_left">{radio data=C('ROLE_TYPE') name="role_type" value=$rs.role_type}</td>
    </tr>
    </tbody>
  </table>
</div>
</form> 

