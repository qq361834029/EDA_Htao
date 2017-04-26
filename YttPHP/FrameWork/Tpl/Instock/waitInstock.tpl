{wz}
<form method="POST" action="{'Instock/waitInstock'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.load_container_no}：</label>
			
			<input type="text" name="query[load_container_no]" url="{'AutoComplete/loadContainerNo'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.container_no}：</label>
			<input type="text" name="query[container_no]" url="{'AutoComplete/containerNo'|U}" jqac />
        </dt>
		<dt class="w320">
			<label>{$lang.from_arrive_date}：</label>
			<input type="text" name="date[from_expect_arrive_date]"  class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_arrive_date}</label>
			<input type="text" name="date[to_expect_arrive_date]"  class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>  
	</dl> 
__SEARCH_END__
</form>
{note tabs="instock"}
<div id="print" class="width98">
{include file="Instock/waitList.tpl"}
</div> 