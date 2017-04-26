{detail_table flow='out_batch' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 
	warehouse=true
	thead=[$lang.number,$lang.pack_box_no,$lang.internal_quantity,$lang.bag_weight]}
<tr index="{$index}" class="{$none}{if $item.has_abnormal > 0} tr_background-color-deleted{/if}" class="t_left">
	<input type="hidden" name="detail[{$index}][pack_box_id]" value="{$item.pack_box_id}" id="warehouse_id">

	{td id="number" name="number" width="" width="56" class="t_left"}
        {$index}
	{/td}
	
	{td id="pack_box_no" class="t_left" width="320"}
        <a href="javascript:;" onclick="addTab('{$item.url}','{$lang.view_pack_box}',1); ">  
        {$item.pack_box_no}
        </a>
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
        {$item.dml_quantity}
	{/td}

    {td type="flow_weight" view="dml_weight"  width="56" tfoot=[total_weight=>""]  tfoot_value="{$rs.detail_total.dml_weight}" tfoot_id="total_weight" class="t_right"}
        {$item.dml_weight}
	{/td}
	
	{detail_operation}
</tr>
{/detail_table}