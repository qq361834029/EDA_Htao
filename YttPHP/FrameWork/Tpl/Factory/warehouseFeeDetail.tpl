{detail_table flow='sale' from=$rs.warehouse_fee action=['view'] op_show=['add','edit'] tfoot=false
	add_thead=true thead=[$lang.start_days,$lang.end_days,$lang.first_quarter,$lang.second_quarter,$lang.third_quarter,$lang.fourth_quarter]}
<tr index="{$index}" class="{$none}" >
	{td view='start_days'}
        <input type="text" name="warehouse_fee[{$index}][start_days]" class="w50 disabled" id="start_days" value="{if empty($item.start_days)}0{else}{$item.start_days}{/if}" readonly>
    {/td}
	{td view='end_days'}
		<input type="text" name="warehouse_fee[{$index}][end_days]" class="w50" id="end_days" onchange="setNextStartDay(this)" value="{$item.end_days}">
	{/td}
	{td view='edml_first_quarter'}
		<input type="text" name="warehouse_fee[{$index}][first_quarter]" class="w50" id="first_quarter" value="{$item.edml_first_quarter}">
	{/td}
	{td view='edml_second_quarter'}
		<input type="text" name="warehouse_fee[{$index}][second_quarter]" class="w50" id="second_quarter" value="{$item.edml_second_quarter}">
	{/td}
	{td view='edml_third_quarter'}
		<input type="text" name="warehouse_fee[{$index}][third_quarter]" class="w50" id="third_quarter" value="{$item.edml_third_quarter}">
	{/td}
	{td view='edml_fourth_quarter'}
		<input type="text" name="warehouse_fee[{$index}][fourth_quarter]" class="w50" id="fourth_quarter" value="{$item.edml_fourth_quarter}">
	{/td}
	{detail_operation}
</tr>
{/detail_table}