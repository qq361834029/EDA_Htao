<form action="{'Size/insert'|U}" method="POST" name="Basic_addSize" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$info.id}" class="spc_input" >
    <tr>
      <td class="width10">{$lang.size_no}：</td>
      <td class="t_left"><input type="text" name="size_no" id="size_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.size_name}：</td>
      <td class="t_left"><input type="text" name="size_name" value="" class="spc_input"/>__*__</td>
    </tr>
    </tbody>
  </table> 
</div>
</form>