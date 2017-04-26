{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
{assign var="action" value=['add','edit']}
{assign var="deal_state" value=['instock_type'=>[2,3,4,5,6,7,8,9,10,11,12]]}
{else}
{assign var="action" value=['add']}
{assign var="deal_state" value=['instock_type'=>[1,2,3,4,5,6,7,8,9,10,11,12]]}
{/if}
{detail_table flow='instock' from=$rs.box action=['view'] op_show=$action 
	thead=['flow_box_id_config',$lang.box_no,$lang.spec_detail,$lang.weight_with_unit,$lang.comments,'flow_check_config']}
<tr index="{$index}" class="{$none}">
{if $tpl_module_name == 'view' || $smarty.const.ACTION_NAME == 'view'}
	<td class="t_left w60">
        {$item.id}
	</td>
	<td class="t_left w60">
        {$item.box_no}
	</td>
{else}
	{td view="box_no" class="t_left w60" viewstate=$deal_state}
		<input type="hidden" name="box[{$index}][id]" value="{$item.id}">
		<input type="text" name="box[{$index}][box_no]" value="{$item.box_no}" class="w60 t_left" />
	{/td}
{/if}
	{td view="s_cube" viewstate=$deal_state tfoot=[total_col_cube=>""] tfoot_value=$rs.box_total.dml_cube}
		<input type="text" name="box[{$index}][cube_long]" id="cube_long" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_cube_long}" row_total {$readonly}> *
		<input type="text" name="box[{$index}][cube_wide]" id="cube_wide" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_cube_wide}" row_total {$readonly}> *
		<input type="text" name="box[{$index}][cube_high]" id="cube_high" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_cube_high}" row_total {$readonly}>
		= <input type="text" id="cube" value="{$item.edml_cube}" readonly="readonly" onchange="changeColorByLimit(this, 100,'head_way',2)" class="disabled w50"/>
	{/td}	
	{td id="span_product_weight" view="weight" class="w60" tfoot=[total_col_weight=>""] tfoot_value=$rs.box_total.dml_weight viewstate=$deal_state}
	<input type="text" id="weight" name="box[{$index}][weight]" onkeyup="changeColorByLimit(this, 30000,'head_way',2)" value="{$item.edml_weight}" {$readonly} row_total class="w60">
	{/td}
{if $tpl_module_name == 'view' || $smarty.const.ACTION_NAME == 'view'}
	<td class="w180">
        {$item.edit_comments}
	</td>
{else}
	{td view="edit_comments" viewstate=$deal_state class="w180"}
	<input type="text" name="box[{$index}][comments]" value="{$item.edit_comments}" {$readonly} style="width: 180px !important;">
	{/td}
{/if}
	{td type="flow_check_config" view="s_check_cube" tfoot=[total_col_check_cube=>""] tfoot_value=$rs.box_total.dml_check_cube}
		<input type="text" name="box[{$index}][check_long]" id="cube_long" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_check_long}" row_total {$readonly}> *
		<input type="text" name="box[{$index}][check_wide]" id="cube_wide" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_check_wide}" row_total {$readonly}> *
		<input type="text" name="box[{$index}][check_high]" id="cube_high" onkeyup="getToTtalCube(this);" class="w40" value="{$item.edml_check_high}" row_total {$readonly}>
		= <input type="text" id="cube" value="{$item.edml_check_cube}" readonly="readonly" class="disabled w50"/>
	{/td}	
	{td type="flow_check_config" id="span_product_check_weight" view="check_weight" class="w80" tfoot=[total_col_check_weight=>""] tfoot_value=$rs.box_total.dml_check_weight}
	<input type="text" id="check_weight" name="box[{$index}][check_weight]" value="{$item.edml_check_weight}" {$readonly} row_total class="w80">
	{/td}
{if $tpl_module_name == 'view' || $smarty.const.ACTION_NAME == 'view'}
	<td class="w60">
        {$item.dd_check_status}
	</td>
	<td class="w180">
        {$item.edit_check_comments}
	</td>
{else}
	{td type="flow_check_config" view="dd_check_status" class="w60"}
		{select combobox="1" name="box[$index][check_status]" data=C('CHECK_STATUS') no_default=true value=$item.check_status}
	{/td}
	{td type="flow_check_config" view="edit_check_comments" class="w180"}
	<input type="text" name="box[{$index}][check_comments]" value="{$item.edit_check_comments}" {$readonly} style="width: 180px !important;">
	{/td}
	{detail_operation}
{/if}
</tr>
{/detail_table}
