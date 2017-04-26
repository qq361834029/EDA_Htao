{if $rs.is_out_batch}
    {assign var='action' value=['add']}
    {else}
    {assign var='action' value=['add','edit']}
{/if}
{detail_table id='detail_table' flow='PackBox' from=$rs.detail action=['view','edit'] op_show=$action
	warehouse=true
	thead=[$lang.return_logistics_no,$lang.return_waybill_no,$lang.parcel_weight,$lang.state]}
<tr index="{$index}" class="{$none}" class="t_left">
    <input type="hidden" value="{$item.id}" name="detail[1][id]">
    <input type="hidden" name="detail[{$index}][return_sale_order_id]" id="return_sale_order_id" value="{$item.return_sale_order_id}" jqproc class="w100">
        
	{td id="return_logistics_no" width="" width="56" class="t_left"}
        <a href="javascript:;" onclick="addTab('{$item.url}','{$lang.view_return_order}',1); ">
        {$item.return_logistics_no}
        </a>
	{/td}
	
	{td id="return_track_no" class="t_left" width="320"}
        <a href="javascript:;" onclick="addTab('{$item.url}','{$lang.view_return_order}',1); ">  
        {$item.return_track_no}
        </a>
	{/td}

	{td id="weight" class="t_left" view="weight" width="320"}
        {$item.dml_weight}
    {/td}
    
	{td id="parcel_state" view="dd_parcel_state"  width="56" class="t_right"}
        {select data=C('PARCEL_STATE') name="detail[{$index}][parcel_state]" value={$item.parcel_state} combobox='' empty=true}
	{/td}
    {if !$rs.is_out_batch }
        {detail_operation}
    {/if}
</tr>
{/detail_table}