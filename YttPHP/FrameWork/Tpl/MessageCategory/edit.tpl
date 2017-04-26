<form action="{'MessageCategory/update'|U}" method="POST" name="Basic_addMessageCategory" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
 <tbody>
    <input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
     <tr>
      <td>{$lang.category_no}：</td>
      <td class="t_left">
	  <input type="text" name="category_no" value="{$rs.category_no}" >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.category_name}：</td>
      <td class="t_left">
      <input type="text" name="category_name" class="spc_input" value="{$rs.category_name}">__*__
      </td>
    </tr>
    </tbody>
  </table>
</div>
</form>

