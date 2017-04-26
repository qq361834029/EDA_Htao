<form action="{'SkuKeywords/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="return false">
{wz action="save,list,reset"}
  <input type="hidden" name="id" value="{$rs.id}">
  <input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
  <div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr><th colspan="2">{$lang.basic_title}</th></tr>
    <tr>
      <td class="width15">{$lang.id}：</td>
      <td class="t_left">{$rs.id}
      </td>
    </tr>	
    <tr>
      <td class="width15">{$lang.product_no}：</td>
      <td class="t_left"><input type="text" name="product_no"  value="{$rs.product_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    
     <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><textarea name="comments">{$rs.edit_comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
  </div>
</form>
