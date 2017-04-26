{detail_table flow='warehosue_fee' from=$rs.detail action=['view'] op_show=['add','edit'] tfoot=false
	thead=[$lang.warehouse_name,$lang.free_days,$lang.first_quarter,$lang.second_quarter,$lang.third_quarter,$lang.fourth_quarter,$lang.over_year]}
    <tr index="{$index}" class="{$none}" style="color: #222222 !important;">
    <input type="hidden" name="detail[{$index}][warehouse_id]" value="{$item.warehouse_id}">
	{td view='w_name'}
        {$item.w_name}
    {/td}
	{td view='free_days'}
		<input type="text" name="detail[{$index}][free_days]" class="" id="free_days" value="{$item.free_days}">
	{/td}
	{td view='edml_first_quarter'}
		<input type="text" name="detail[{$index}][first_quarter]" class="" id="first_quarter" value="{$item.edml_first_quarter}">
	{/td}
	{td view='edml_second_quarter'}
		<input type="text" name="detail[{$index}][second_quarter]" class="" id="second_quarter" value="{$item.edml_second_quarter}">
	{/td}
	{td view='edml_third_quarter'}
		<input type="text" name="detail[{$index}][third_quarter]" class="" id="third_quarter" value="{$item.edml_third_quarter}">
	{/td}
	{td view='edml_fourth_quarter'}
		<input type="text" name="detail[{$index}][fourth_quarter]" class="" id="fourth_quarter" value="{$item.edml_fourth_quarter}">
	{/td}
	{td view='edml_over_year'}
		<input type="text" name="detail[{$index}][over_year]" class="" id="over_year" value="{$item.edml_over_year}">
	{/td}
</tr>
{/detail_table}