<form action="{'Ajax/setReviewWeight'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="module" value="{$smarty.get.module}" />
<div class="table_autoshow" style="border-style:none!important; width: 360px!important;">
{detail_table id='detail_review_weight_table' flow='setReviewWeight' from=$rs.detail action=['setReviewWeight'] op_show=false 
	warehouse=true
	thead=[$lang.return_logistics_no,$lang.return_waybill_no,$lang.parcel_weight,$lang.review_weight] tfoot=false}
<tr index="{$index}" class="{$none}" class="t_left">
    <input type="hidden" name="detail[{$index}][return_sale_order_id]" id="return_sale_order_id" value="{$item.return_sale_order_id}" jqproc class="w100">
        
	{td id="return_logistics_no" view="return_logistics_no" class="t_left"}
        {$item.return_logistics_no}
	{/td}
	
	{td id="return_track_no" class="t_left" view="return_track_no"}
        {$item.return_track_no}
	{/td}

	{td id="weight" class="t_left" view="weight"}
        {$item.dml_weight}
    {/td}
    
	{td id="review_weight" view="review_weight" class="t_right"}
        <input type="text" value="{$item.dml_review_weight}" name="detail[{$index}][review_weight]">
	{/td}
    
	{detail_operation}
</tr>
{/detail_table}
</div>
</form> 