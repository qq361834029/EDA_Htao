<form action="{'Ajax/setAssociateWithState'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="module" value="{$smarty.get.module}" />
<div class="table_autoshow" style="border-style:none!important; width: 360px!important;">
{detail_table id='detail_associate_with_table' flow='setAssociateWithState' from=$rs.detail action=['setAssociateWithState'] op_show=false 
	warehouse=true
	thead=[$lang.return_logistics_no,$lang.return_waybill_no,$lang.parcel_weight,$lang.state] tfoot=false}
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
    
	{td id="associate_with_state" view="dd_associate_with_state" class="t_right"}
        {select style="width:75px" data=C('ASSOCIATE_WITH_STATE') name="detail[{$index}][associate_with_state]" value={$item.associate_with_state} combobox='' empty=true}
	{/td}
    
	{detail_operation}
</tr>
{/detail_table}
</div>
</form> 