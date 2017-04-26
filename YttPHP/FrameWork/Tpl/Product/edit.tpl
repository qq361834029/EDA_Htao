<form action="{'Product/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="return false">
{wz action="save,list,reset"}
  <input type="hidden" name="id" value="{$rs.id}">
  <input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
  <input type="hidden" name="file_tocken" value="{$file_tocken}">
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
      <td class="t_left"><input {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{/if} type="text" name="product_no"  value="{$rs.product_no}" {$is_auto_no} class="spc_input" maxlength="35">__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.product_name}：</td>
      <td class="t_left"><input type="text" name="product_name" value="{$rs.product_name}" {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if} maxlength="35" >__*__
      </td>
    </tr>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left"> 
      <input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}"> 
      {if $rs.factory_readonly}
      {$rs.factory_name}
      {else}
      <!--input id="factory_name" value="{$rs.factory_name},{$rs.comp_email}" url="{'/AutoComplete/factoryEmail'|U}" jqac>__*__-->
      {$rs.factory_name}
      {/if}
      </td>
    </tr>
	{else}
		<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}"> 
	{/if}
    <tr>
      <td>{$lang.custom_barcode}：</td>
      <td class="t_left">
          {$rs.custom_barcode}
      </td>
    </tr>
    <tr><th colspan="2">{$lang.propre_title}</th></tr>
<tr>
<td>{$lang.product_size}：</td>
<td class="t_left">
{$lang.long}<input  name="cube_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);"  value="{if $rs.edml_cube_long>0}{$rs.edml_cube_long}{/if}"  {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if} style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.wide}<input  name="cube_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);"  value="{if $rs.edml_cube_wide>0}{$rs.edml_cube_wide}{/if}"  {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if} style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.high}<input  name="cube_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);"  value="{if $rs.edml_cube_high>0}{$rs.edml_cube_high}{/if}"   {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if} style="width:80px!important;"/>{C('SIZE_UNIT')}
=<input name="cube" id="cube" type="text" readonly    value="{$rs.edml_cube}" class="spc_input disabled" style="width:80px!important;"/>{C('VOLUME_SIZE_UNIT')}__*__{L('product_size_notice')}
</td>
</tr>
<tr>
<td>{$lang.weight}：</td>
<td class="t_left"><input  name="weight" id="weight" type="text" value="{if $rs.edml_weight>0}{$rs.edml_weight}{/if}" {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if}/> {C('WEIGHT_UNIT')}__*__{L('product_weight_notice')}
</td>
</tr>
<tr>
<td>{$lang.storage_remind}：</td>
<td class="t_left">
<input name="warning_quantity" id="warning_quantity" value="{$rs.warning_quantity}" type="text" {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="spc_input disabled"{else}class="spc_input"{/if}/>
</td>
</tr>

{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
<tr>
<td>{$lang.check_product_size}：</td>
<td class="t_left">
{$lang.long}<input name="check_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" value="{if $rs.edml_check_long>0}{$rs.edml_check_long}{/if}" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.wide}<input name="check_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" value="{if $rs.edml_check_wide>0}{$rs.edml_check_wide}{/if}" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')} *
{$lang.high}<input name="check_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" value="{if $rs.edml_check_high>0}{$rs.edml_check_high}{/if}" class="spc_input" style="width:80px!important;"/>{C('SIZE_UNIT')}
=<input name="check_cube" id="cube" type="text" readonly  value="{$rs.edml_check_cube}" class="spc_input disabled" style="width:80px!important;"/>{C('VOLUME_SIZE_UNIT')}
</td>
</tr>
<tr>
<td>{$lang.check_weight}：</td>
<td class="t_left"><input name="check_weight" id="weight" type="text" value="{if $rs.edml_check_weight>0}{$rs.edml_check_weight}{/if}"  class="spc_input"/> {C('WEIGHT_UNIT')}
</td>
</tr>
<tr>
<td>{$lang.check_status}：</td>
<td class="t_left">{select combobox="1" name="check_status" data=C('CHECK_STATUS') no_default=true value=$rs.check_status}
</td>
</tr>
<tr>
<td valign="top">{$lang.check_comments}：</td>
<td class="t_left"><textarea name="check_comments">{$rs.edit_check_comments}</textarea>
</td>
</tr>
{/if}
{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
<tr>
<td>{$lang.product_pics}：</td>
<td class="t_left">
{upload tocken=$file_tocken sid=$sid type=1}
</td>
</tr> 
{/if}
{if $rs.pics}
<tr>
<td>{$lang.product_pics}：</td>
<td class="t_left">{showFiles from=$rs.pics delete=$login_user.role_type==C('SELLER_ROLE_TYPE')}
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
    {foreach key=key item=item from=$rs.detail}
    <input type="hidden" name="product_detail[{$key}][id]" value="{$item.id}">
    <input type="hidden" name="product_detail[{$key}][properties_id]" value="{$item.properties_id}">
    <tr>
      <td>{$item.$properties_name}：</td>
      <td class="t_left">
      {if $item.properties_type==1}
      <input type="text" name="product_detail[{$key}][value]" value="{$item.value}" class="spc_input">
      {elseif $item.properties_type==2}
      {select combobox="1" name="product_detail[`$key`][value]" value="`$item.value`" table="properties_value" key="id" field=$pv_name where="id in(select properties_value_id from properties_info where properties_id=`$item.properties_id`) and to_hide=1" empty=true}
      {elseif $item.properties_type==3}
      {checkbox name="product_detail[`$key`][value][]" value="`$item.value`" table="properties_value" key="id" field=$pv_name where="id in(select properties_value_id from properties_info where properties_id=`$item.properties_id`) and to_hide=1"}
       {elseif $item.properties_type==4}
       <textarea name="product_detail[{$key}][value]">{$item.value}</textarea>
      {/if}
      </td>
    </tr>
    {/foreach}
     <tr>
      <td valign="top">{$lang.import_sku}：</td>
      <td class="t_left">
      <input type="text" name="product_sku[0]" value="{$rs.product_sku.0}" class="spc_input">
      <input type="text" name="product_sku[1]" value="{$rs.product_sku.1}" class="spc_input">
      <input type="text" name="product_sku[2]" value="{$rs.product_sku.2}" class="spc_input">
      <input type="text" name="product_sku[3]" value="{$rs.product_sku.3}" class="spc_input">
      <input type="text" name="product_sku[4]" value="{$rs.product_sku.4}" class="spc_input">
      </td>
    </tr>
     <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><textarea {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}readonly class="disabled" {/if} name="comments">{$rs.edit_comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
  </div>
</form>
