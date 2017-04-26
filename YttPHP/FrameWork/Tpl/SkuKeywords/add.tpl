<script type="text/javascript" src="__PUBLIC__/Js/lodopFuncs.js"></script>
<form action="{'SkuKeywords/insert'|U}" method="POST" name="Basic_addProductClass" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr><th colspan="2">{$lang.basic_title}</th></tr>
    <tr>
      <td class="width15">{$lang.product_no}：</td>
      <td class="t_left"><input type="text"  name="product_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
     <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><textarea name="comments"></textarea>
      </td>
    </tr>
    </tbody>
  </table> 
  </div>
    <br><br>
</form>
