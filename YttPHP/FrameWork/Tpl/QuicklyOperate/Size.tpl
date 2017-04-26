<form action="{'Size/insert'|U}" method="POST" name="Basic_addSize" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
  <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$info.id}" class="spc_input" >
     <tr>
       <th colspan="2">{$lang.size_message}</th>
    </tr>
    <tr>
      <td class="width20">{$lang.size_no}：</td>
      <td class="t_left"><input type="text" name="size_no" id="basic_name"  value="{$max_no}" {$is_auto_no} >__*__
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
