<form action="{'Properties/insert'|U}" method="POST" name="Basic_addProperties" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
     <tr>
      <td class="width10">{$lang.properties_no}：</td>
      <td class="t_left">
      <input type="text" name="properties_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_name}：</td>
      <td class="t_left">
      <input type="text" name="properties_name" class="spc_input" >__*__（{'SYSTEM_LANG.cn'|C}）
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_name}：</td>
      <td class="t_left">
      <input type="text" name="properties_name_de" class="spc_input" >__*__（{'SYSTEM_LANG.de'|C}）
      </td>
    </tr>
    <tr>
      <td>{$lang.properties_type}：</td>
      <td class="t_left">{radio data=C('PROPERTIES_TYPE') name="properties_type"  value=1}</td>
    </tr>
    <tr>
      <td>{$lang.role_type}：</td>
      <td class="t_left">{radio data=C('ROLE_TYPE') name="role_type" value=1}</td>
    </tr>
    </tbody>
  </table>
</div>
</form> 

