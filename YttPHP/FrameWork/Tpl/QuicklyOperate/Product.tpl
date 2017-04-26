<form action="{'Product/insert'|U}" method="POST" name="Basic_addProductClass" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
 <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr><th colspan="2">{$lang.basic_title}</th></tr>
    <tr>
      <td class="width20">{$lang.product_no}：</td>
      <td class="t_left"><input type="text"   name="product_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.product_name}：</td>
      <td class="t_left"><input type="text" name="product_name" class="spc_input" >__*__
      </td>
    </tr>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left">
      <input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
      <input id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac itemto="dialog-quickly_add">__*__
      </td>
    </tr>    
	{else}
		<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
	{/if}
    	<tr>
      		<td class="width20">{$lang.cube}：</td>
<td class="t_left">

{$lang.long}<input name="cube_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M *
{$lang.wide}<input name="cube_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M *
{$lang.high}<input name="cube_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M
=<input name="cube" id="cube" type="text" readonly  class="spc_input readonly" style="width:60px!important;"/>M³

</td>
</tr>
<tr>
<td>{$lang.weight}：</td>
<td class="t_left"><input name="weight" id="weight" type="text"  class="spc_input"/> KG
</td>
</tr> 
{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    	<tr>
      		<td class="width20">{$lang.check_cube}：</td>
<td class="t_left">

{$lang.long}<input name="check_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M *
{$lang.wide}<input name="check_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M *
{$lang.high}<input name="check_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:60px!important;"/>M
=<input name="check_cube" id="cube" type="text" readonly  class="spc_input readonly" style="width:60px!important;"/>M³

</td>
</tr>
<tr>
<td>{$lang.checkweight}：</td>
<td class="t_left"><input name="weight" id="weight" type="text"  class="spc_input"/> KG
</td>
</tr> 
<tr>
<td>{$lang.check_status}：</td>
<td class="t_left">{select combobox="1" name="check_status" data=C('CHECK_STATUS') no_default=true value=0}
</td>
</tr>
<tr>
<td valign="top">{$lang.check_comments}：</td>
<td class="t_left"><textarea name="check_comments"></textarea>
</td>
</tr>
{/if}
{if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
{assign var="properties_name" value="properties_name_de"}
{assign var="pv_name" value="pv_name_de"}
{else}
{assign var="properties_name" value="properties_name"}
{assign var="pv_name" value="pv_name"}
{/if}
    {foreach key=key item=item from=$properties}
    <input type="hidden" name="product_detail[{$key}][properties_id]" value="{$item.id}">
    <tr>
      <td>{$item.$properties_name}：</td>
      <td class="t_left">
      {if $item.properties_type==1}
      <input type="text" name="product_detail[{$key}][value]" class="spc_input">
      {elseif $item.properties_type==2}
      {select combobox="1" name="product_detail[`$key`][value]" table="properties_value" key="id" field=$pv_name where="id in(select properties_value_id from properties_info where properties_id=`$item.id`) and to_hide=1" empty=true}
      {elseif $item.properties_type==3}
      {checkbox name="product_detail[`$key`][value][]" table="properties_value" key="id" field=$pv_name where="id in(select properties_value_id from properties_info where properties_id=`$item.id`) and to_hide=1"}
      {/if}
      </td>
    </tr>
    {/foreach}
     <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><textarea name="comments"></textarea>
      </td>
    </tr>
    </tbody>
  </table> 
  </div>
</form>
