{detail_table flow='out_batch' from=$rs.detail action=['view','edit'] op_show=['add','edit'] 

	thead=[$lang.number,$lang.pack_box_no,$lang.internal_quantity,$lang.bag_weight,$lang.review_weight_g,$lang.review_cube]}
<tr index="{$index}" class="{$none}" class="t_left">
    <input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
	<input type="hidden" name="detail[{$index}][pack_box_id]" value="{$item.pack_box_id}" id="pack_box_id">
	<input value='{$item.state}' type="hidden" name="detail[{$index}][state]"  id="state">
	{td id="number" name="number" width="" width="56" class="t_left"}
        {$index}
	{/td}
	
	{td id="pack_box_no" class="t_left" view="pack_box_no" width="320"}
        <a href="javascript:;" onclick="addTab('{$item.url}','{$lang.view_pack_box}',1); ">  
        {$item.pack_box_no}
        </a>
	{/td}

	{td type="flow_quantity" view="dml_quantity"  width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
        {$item.dml_quantity}
	{/td}

    {td type="flow_weight" id="weight" view="dml_weight"  width="56" tfoot=[total_weight=>""]  tfoot_value="{$rs.detail_total.dml_weight}" tfoot_id="total_weight" class="t_right"}
        {$item.dml_weight}
	{/td}
    {td view="dml_review_weight" id="total_review_weight" width="56" class="t_right" tfoot=[total_review_weight=>""]  tfoot_value="{$rs.detail_total.dml_review_weight}" tfoot_id="total_review_weight" class="t_right"}
        <input type="text" id="review_weight" name="detail[{$index}][review_weight]"  value="{$item.edml_review_weight}" class="w80" total_review_weight>
    {/td}
    {td view="dml_review_cube" id="total_review_cube" width="56" class="t_right" tfoot=[total_review_cube=>""]  tfoot_value="{$rs.detail_total.dml_review_cube}" tfoot_id="total_review_cube" class="t_right"}
        <input type="text"  id="review_cube" name="detail[{$index}][review_cube]"  value="{$item.edml_review_cube}" class="w80" total_review_cube>
    {/td}
	{detail_operation}
</tr>
{/detail_table}