{if $tpl_action_name}
{assign var="op_action" value=$tpl_action_name}
{else}
{assign var="op_action" value={$smarty.const.ACTION_NAME}}
{/if}

{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    {assign var=thead   value=[$lang.area,$lang.country_name,$lang.postcode_interval_with_note,$lang.weight_interval_with_unit,$lang.bulk_with_unit,$lang.basic_price,$lang.cost,$lang.step_price,$lang.is_express,$lang.registration_fee,$lang.registration_cost,$lang.return_fee]}
{else}
    {assign var=thead   value=[$lang.area,$lang.country_name,$lang.postcode_interval_with_note,$lang.weight_interval_with_unit,$lang.bulk_with_unit,$lang.basic_price,$lang.step_price,$lang.is_express,$lang.registration_fee,$lang.return_fee]}
{/if}
    
{detail_table flow='shipping' from=$rs.detail action=['view','edit'] op_show=['add','edit']
	thead=$thead}
<tr index="{$index}" class="{$none}">
	{td view="area" class="w60"}
		<input type="hidden" id="detail_id" name="detail[{$index}][id]" value="{$item.id}">
		<input type="text" name="detail[{$index}][area]" value="{$item.area}" {$readonly} class="w60">
	{/td}
	{td id="span_country_name" view="edit_country_name" class="w150"}
		<input type="hidden" name="detail[{$index}][country_id]" value="{$item.country}" class="w150">
		<textarea name="country_name" id="country_name" onclick="selectCountry(this);return false;" readonly="readonly" style="height:40px" class="w150">{$item.country_name}</textarea>
	{/td}
	{td view="view_post_section" class="w100"  class="{if $smarty.const.ACTION_NAME eq 'view' and $item.post_is_express neq 1}disabled{/if}"}
		{$lang.is_express}:{radio data=C('IS_ENABLE') name="detail[{$index}][post_is_express]" value="{$item.post_is_express}" initvalue=2}<br />
        <input type="hidden" id="post_section" name="detail[{$index}][post_section]" value='{$item.post_section}'>
        <span class="icon icon-list-addInvoice" title="{$lang.copy}" onclick="$.setPostSection(this,'{$item.id}')"></span>
        {*		<input type="text" name="detail[{$index}][post_begin]" value="{$item.post_begin}" {$readonly} class="w50">-
		<input type="text" name="detail[{$index}][post_end]" value="{$item.post_end}" {$readonly} class="w50">*}
	{/td}
	{td view="dml_weight_begin,dml_weight_end" view_delimiter="-" class="w120"}
		<input type="text" name="detail[{$index}][weight_begin]" value="{$item.edml_weight_begin}" {$readonly} class="w50">-
		<input type="text" name="detail[{$index}][weight_end]" value="{$item.edml_weight_end}" {$readonly} class="w50">
	{/td}
	{td view="s_cube" class="w180"}
		<input type="text" name="detail[{$index}][cube_long]" id="cube_long" onkeyup="getToTtalCube(this);" class="w50" value="{$item.edml_cube_long}" {$readonly}>*
		<input type="text" name="detail[{$index}][cube_wide]" id="cube_wide" onkeyup="getToTtalCube(this);" class="w50" value="{$item.edml_cube_wide}" {$readonly}>*
		<input type="text" name="detail[{$index}][cube_high]" id="cube_high" onkeyup="getToTtalCube(this);" class="w50" value="{$item.edml_cube_high}" {$readonly}>=
		<input type="text" id="cube" value="{$item.edml_cube}" readonly="readonly" class="disabled w80"/>
	{/td}		
	{td view="dml_price" class="w50"}
		<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" {$readonly} class="w50"/>
	{/td}
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
        {td view="dml_cost" class="w50"}
            <input type="text" name="detail[{$index}][cost]" id="price" value="{$item.edml_cost}" {$readonly} class="w50"/>
        {/td}
    {/if}
	{td view="edml_step_price" class="w60"}
		<input type="text" name="detail[{$index}][step_price]" id="step_price" value="{$item.edml_step_price}" {$readonly} class="w60"/>
	{/td}
	{td view="dd_is_express" width="w50"}
		{radio data=C('IS_ENABLE') name="detail[{$index}][is_express]" value="{$item.is_express}" initvalue=1}
	{/td}
	{td view="dml_registration_fee" width="w50"}
		<input type="text" name="detail[{$index}][registration_fee]" id="registration_fee" value="{$item.edml_registration_fee}" {$readonly} class="w50"/>
	{/td}
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
        {td view="dml_registration_cost" width="w50"}
            <input type="text" name="detail[{$index}][registration_cost]" id="registration_cost" value="{$item.edml_registration_cost}" {$readonly} class="w50"/>
        {/td}	
    {/if}
	{td view="dml_return_fee" width="w50"}
		<input type="text" name="detail[{$index}][return_fee]" id="return_fee" value="{$item.edml_return_fee}" {$readonly} class="w50"/>
	{/td}
	{detail_operation}
</tr>
{/detail_table}
