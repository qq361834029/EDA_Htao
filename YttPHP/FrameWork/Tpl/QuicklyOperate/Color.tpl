<form action="{'Color/insert'|U}" method="POST" name="Basic_addColor" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
  <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$info.id}" class="spc_input" >
      <tr>
    		<th colspan="2">{$lang.color_message}</th>
    	</tr>
    <tr>
      <td class="width20">{$lang.color_no}：</td>
      <td class="t_left"><input type="text" name="color_no" id="basic_name" value="{$max_no}"  {$is_auto_no}>__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.color_name}：</td>
      <td class="t_left"><input type="text" name="color_name" value="" class="spc_input"/>__*__</td>
    </tr>
    </tbody>
  </table> 
  </div>
</form>
