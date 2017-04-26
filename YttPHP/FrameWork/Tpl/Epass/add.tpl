<form action="{'Epass/insert'|U}" method="POST" name="Basic_addEpass" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
   <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$info.id}" class="spc_input" >
    <tr>
      <td class="width15">{$lang.epass_serial}：</td>
      <td class="t_left"><input type="text" name="epass_serial" id="epass_serial" value="" style="width:280px;border: 1px solid #bbbbbb;line-height:20px;height:20px;">__*__
      </td>
    </tr>
    <tr>
      <td class="width15">{$lang.epass_no}：</td>
      <td class="t_left"><input type="text" name="epass_no" id="epass_no" value="" style="width:280px;border: 1px solid #bbbbbb;line-height:20px;height:20px;">__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.epass_key}：</td>
      <td class="t_left"><input type="text"  name="epass_key" id="epass_key" value="{$epass_key}" style="width:280px;border: 1px solid #bbbbbb;line-height:20px;height:20px;">__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.epass_data}：</td>
      <td class="t_left"><input type="text"  name="epass_data" id="epass_data" value="{$epass_date}" style="width:280px;border: 1px solid #bbbbbb;line-height:20px;height:20px;">__*__
      </td>
    </tr> 
    </tbody>
  </table> 
</div>
</form>
