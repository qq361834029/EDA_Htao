<tr><td colspan="4">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="square">
  <tr>
    <td class="bordor-none wordred width50">{$lang.is_close_out}：</td>
    <td class="t_left bordor-none" >
      	<input type="radio" name="close_out" value="1" checked/>{$lang.no}
      	<input type="radio" name="close_out" value="2" {if $funds.close_out.list.0.id>0} checked {/if} />{$lang.yes} 
   </td>
  </tr>
  <tr>
    <td class="bordor-none">{$lang.close_out_comments}：</td>
    <td class="t_left bordor-none" ><input type="text" name="close_out_comments" class="input300" value="{$funds.close_out.list.0.comments}"/></td>
</tr>