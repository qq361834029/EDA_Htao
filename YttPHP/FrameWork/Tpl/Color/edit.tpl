<form action="{'Color/update'|U}" method="POST" name="Basic_addColor" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
    <tr> 
      <td class="width10">{$lang.color_no}：</td>
      <td class="t_left"><input type="text" name="color_no" id="color_no" value="{$rs.color_no}" {$is_auto_no}>__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.color_name}：</td>
      <td class="t_left"><input type="text" name="color_name" value="{$rs.color_name}" class="spc_input"/>__*__</td>
    </tr>
    </tbody>
  </table> 
</div>
</form>
