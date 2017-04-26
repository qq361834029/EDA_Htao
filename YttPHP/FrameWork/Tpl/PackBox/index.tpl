{wz}
<form method="POST" action="{"PackBox/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
        <input type="hidden" id="record_check_token" name="record_check_token" value="{$record_check_token}">
        <dt>
            <label>{$lang.warehouse_name}：</label>
            <input type="hidden" id="warehouse_id" name="main[query][warehouse_id]" >
            <input type="text" id="w_name" name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" jqac /> 
        </dt>
		<dt>
			<label>{$lang.pack_box_no}：</label>
			<input value="{$smarty.post.main.like.pack_box_no}" type="text" name="main[like][pack_box_no]" url="{'/AutoComplete/packBoxNo'|U}" jqac>
		</dt>
        <dt>
			<label>{$lang.packed_start_date}：</label>
			<input type="text" name="main[date][needdate_from_pack_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.packed_end_date}:</label>
			<input type="text" name="main[date][needdate_to_pack_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
    </dl>
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note out_batch={$record_check_token} clean_check=true}
<div id="print" class="width98">
{include file="PackBox/list.tpl"}
</div> 

