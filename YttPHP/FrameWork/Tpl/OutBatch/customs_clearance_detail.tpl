{detail_table flow='out_batch' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 

	thead=[$lang.number,$lang.pack_box_no,$lang.internal_quantity,$lang.bag_weight,$lang.review_weight_g,$lang.review_cube,$lang.delivery_fee,$lang.state]}
<tr index="{$index}" class="{$none}" class="t_left">
    <input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
	<input type="hidden" name="detail[{$index}][pack_box_id]" value="{$item.pack_box_id}" id="pack_box_id">
	<input value='{$item.state}' type="hidden" name="detail[{$index}][state]"  id="state">
	{td id="number" name="number" width="" width="56" class="t_left"}
        {$index}
	{/td}
	
	{td id="pack_box_no" class="t_left" view="pack_box_no" width="320"}
        <a href="javascript:;" onclick="$.setCustomsClearanceState(this,{$item.pack_box_id})">
            {$item.pack_box_no}
        </a>
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
        {$item.dml_quantity}
	{/td}

    {td type="flow_weight" view="dml_weight"  width="56" tfoot=[total_weight=>""]  tfoot_value="{$rs.detail_total.dml_weight}" tfoot_id="total_weight" class="t_right"}
        {$item.dml_weight}
	{/td}
    {td view="flow_review_weight" id="review_weight" width="56" class="t_right" tfoot=[total_review_weight=>""]  tfoot_value="{$rs.detail_total.dml_review_weight}" tfoot_id="total_review_weight" class="t_right"}
        {$item.dml_review_weight}
    {/td}
    {td view="flow_review_cube" id="review_cube" width="56" class="t_right" tfoot=[total_review_cube=>""]  tfoot_value="{$rs.detail_total.dml_review_cube}" tfoot_id="total_review_cube" class="t_right"}
        {$item.dml_review_cube}
    {/td}
    {td view="flow_freight" id="freight" width="56" class="t_right" tfoot=[total_freight=>""]  tfoot_value="{$rs.detail_total.dml_freight}" tfoot_id="total_freight" class="t_right"}
        {$item.dml_freight}
    {/td}
    {td view="customs_clearance_state_name"  width="56" class="t_right"}
        <input type="hidden" name="detail[{$index}][customs_clearance_state]" value="{$item.customs_clearance_state}" onchange="setDetailState(this);">
        <input name="temp[customs_clearance_state_name]" value="{$item.customs_clearance_state_name}" type='text' url="{'/AutoComplete/customsClearanceState'|U}" jqac>
    {/td}
	{detail_operation}
</tr>
{/detail_table}