{wz}
<form method="POST" action="{"OutBatch/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
        		
		<dt>
			<label>{$lang.transport_start_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_transport_start_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_transport_start_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	
        
		<dt>
			<label>{$lang.out_batch_no}：</label>
			<input value="{$smarty.post.main.like.out_batch_no}" type="text" name="main[like][out_batch_no]" url="{'/AutoComplete/outBatchNo'|U}" jqac>
		</dt>
        
        <dt>
			<label>{$lang.arrive_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_expected_arrival_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_expected_arrival_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
        
		<dt>
			<label>{$lang.pack_box_no}：</label>
			<input value="{$smarty.post.main.like.pack_box_no}" type="text" name="pack_box[like][pack_box_no]" url="{'/AutoComplete/packBoxNo'|U}" jqac>
		</dt>
        
        <dt>
			<label>{$lang.create_time}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_create_time]" value="{$smarty.post.main.date.needdate_from_create_time}" class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_create_time]" value="{$smarty.post.main.date.needdate_to_create_time}" class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>
        
        <dt>
			<label>{$lang.is_associate_with}：</label>
            {select data=C('IS_ASSOCIATE_WITH') value=$smarty.post.main.query.is_associate_with name="main[query][is_associate_with]" combobox=''}
        </dt>
        
        <dt>
			<label>{$lang.is_aliexpress}：</label>
            {select id='is_aliexpress' data=C('IS_ALIEXPRESS') onchange='cleanPackBoxDetail()' value=$smarty.post.pack_box.query.is_aliexpress name="pack_box[query][is_aliexpress]" combobox=""}
        </dt>
		
		</dl>	
	<input type="hidden" name="date_key" value="3">
__SEARCH_END__
</form>
{note insert=false}
<div id="print" class="width98">
{include file="OutBatch/list.tpl"}
</div> 

