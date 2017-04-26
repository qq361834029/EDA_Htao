<form action="{'Package/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
        {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
            <input type="hidden" name="warehouse_id" id="warehouse_id" value="{$login_user.company_id}">
            <tr>
                <td class="width10">{$lang.currency}：</td>
                <td class="t_left">{$rs.currency_no}</td>
            </tr>
        {else}
            <tr>
                <td class="width10">{$lang.belongs_warehouse}：</td>
                <td class="t_left">
                    <input id="warehouse_id"  onchange="showWCurrency(this,'');" value="{$rs.warehouse_id}" type="hidden" name="warehouse_id" class="valid-required">
                    <input id="warehouse_name" value="{$rs.w_name}" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__
                    {$lang.currency}：<span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
                </td>
            </tr>						
        {/if}	
    	<tr>
      		<td class="width10">{$lang.package_name}：</td>
      		<td class="t_left"><input type="text" name="package_name" id="package_name" value="{$rs.package_name}" class="spc_input" >__*__</td>
    	</tr>
	<tr>
		<td>{$lang.package_spec}：</td>
		<td class="t_left"> 
		{$lang.long}<input name="cube_long" id="cube_long" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;" value="{if $rs.edml_cube_long>0}{$rs.edml_cube_long}{/if}"/>{C('SIZE_UNIT')}*
		{$lang.wide}<input name="cube_wide" id="cube_wide" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;" value="{if $rs.edml_cube_wide>0}{$rs.edml_cube_wide}{/if}"/>{C('SIZE_UNIT')}*
		{$lang.high}<input name="cube_high" id="cube_high" type="text" onkeyup="getToTtalCube(this);" class="spc_input" style="width:80px!important;" value="{if $rs.edml_cube_high>0}{$rs.edml_cube_high}{/if}"/>{C('SIZE_UNIT')}
		=<input name="cube" id="cube" type="text" readonly value="{$rs.edml_cube}" class="spc_input readonly" style="width:80px!important;"/>{C('VOLUME_SIZE_UNIT')}
		</td>
	</tr>

    	<tr>
      		<td>{$lang.weight}：</td>
      		<td class="t_left"><input type="text" name="weight" value="{if $rs.dml_weight>0}{$rs.dml_weight}{/if}" class="spc_input"/> {C('WEIGHT_UNIT')}</td>
    	</tr>
    	<tr>
      		<td>{$lang.price}：</td>
      		<td class="t_left"><input type="text" name="price" value="{$rs.edml_price|dml}" class="spc_input"/><span class="t_left" id="show_w_currency">{$rs.currency_no}</span></td>
    	</tr>
     	<tr>
      		<td valign="top">{$lang.comment}：</td>
      		<td class="t_left" valign="top"><textarea name="comments" rows="5" cols="60">{$rs.edit_comments}</textarea></td>
    	</tr>
    </tbody>
</table> 
</div>
</form>