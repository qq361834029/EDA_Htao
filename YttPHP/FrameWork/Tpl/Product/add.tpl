<script type="text/javascript" src="__PUBLIC__/Js/lodopFuncs.js"></script>
<form action="{'Product/insert'|U}" method="POST" name="Basic_addProductClass" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr><th colspan="2">{$lang.basic_title}</th></tr>
    <tr>
      <td class="width15">{$lang.product_no}：</td>
      <td class="t_left"><input type="text"  name="product_no" value="{$max_no}" class="spc_input" {$is_auto_no} maxlength="35" >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.product_name}：</td>
      <td class="t_left"><input type="text" name="product_name" class="spc_input" maxlength="35" >__*__
      </td>
    </tr>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left">
      <input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}" onchange="isCustomBarcode(this)" >
	  <input id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
      </td>
    </tr>    
	{else}
		<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
	{/if}
    <tr  id="is_show_custom_barcode" {if $custom_barcode.is_custom_barcode != 1} style="display: none;"{/if}>
      <td>{$lang.custom_barcode}：</td>
      <td class="t_left">
          <input type="text" name="custom_barcode" id="custom_barcode" class="spc_input" maxlength="19">__*__
{*          <span id="custom_barcode_prompt">请输入{$custom_barcode.custom_barcode_en}加{$custom_barcode.custom_barcode_num}位数字</span>*}
      </td>
    </tr>
    <tr><th colspan="2">{$lang.propre_title}</th></tr>
<tr>
<td>{$lang.product_size}：</td>
<td class="t_left">

{$lang.long}<input name="cube_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.wide}<input name="cube_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.high}<input name="cube_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')}
=<input name="cube" id="cube" type="text" readonly  class="spc_input disabled" style="width:80px!important;"/>{C('VOLUME_SIZE_UNIT')} __*__{L('product_size_notice')}

</td>
</tr>
<tr>
<td>{$lang.weight}：</td>
<td class="t_left"><input name="weight" id="weight" type="text"  class="spc_input"/> {C('WEIGHT_UNIT')}__*__{L('product_weight_notice')}
</td>
</tr>

<tr>
<td>{$lang.storage_remind}：</td>
<td class="t_left">
<input name="warning_quantity" id="warning_quantity" type="text" class="spc_input"/>
</td>
</tr>
{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
<tr>
<td>{$lang.check_product_size}：</td>
<td class="t_left">

{$lang.long}<input name="check_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.wide}<input name="check_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.high}<input name="check_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')}
=<input name="check_cube" id="cube" type="text" readonly  class="spc_input disabled" style="width:80px!important;"/>{C('VOLUME_SIZE_UNIT')}

</td>
</tr>
<tr>
<td>{$lang.check_weight}：</td>
<td class="t_left"><input name="check_weight" id="weight" type="text"  class="spc_input"/> {C('WEIGHT_UNIT')}
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
<tr>
<td>{$lang.product_pics}：</td>
<td class="t_left">
{upload tocken=$file_tocken sid=$sid type=1}
</td>
</tr> 
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
       {elseif $item.properties_type==4}
       <textarea name="product_detail[{$key}][value]"></textarea>
      {/if}
      </td>
    </tr>
    {/foreach}
    <tr>
      <td valign="top">{$lang.import_sku}：</td>
      <td class="t_left"><input type="text" name="product_sku[1]" value="" class="spc_input">
      <input type="text" name="product_sku[2]" value="" class="spc_input">
      <input type="text" name="product_sku[3]" value="" class="spc_input">
      <input type="text" name="product_sku[4]" value="" class="spc_input">
      <input type="text" name="product_sku[5]" value="" class="spc_input">
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
