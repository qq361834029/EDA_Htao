{wz}
<form method="POST" action='{"/StatProductAge/index/search_form/1"|U}' validity="statCheck" id="search_form">
__SEARCH_START__
<dl>
	<dt>
		<label >{$lang.product_no}：</label>
		<input type='hidden' name="query[product_id]">
		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
	</dt>
	<dt>
		<label>{$lang.stop_date}：</label>
		<input class="Wdate spc_input" type="text" value="" onclick="WdatePicker()" name="date[lt_in_date]">
	</dt>            			  
	<dt>
		<label>{$lang.section}：</label>
		<input class="spc_input" type="text" autocomplete="off" style="width:40px !important;" value="" name="age[a]">
		<input class="spc_input" type="text" autocomplete="off" style="width:40px !important;" value="" name="age[b]">
		<input class="spc_input" type="text" autocomplete="off" style="width:40px !important;" value="" name="age[c]">
		<input class="spc_input" type="text" autocomplete="off" style="width:40px !important;" value="" name="age[d]">
	</dt>    
</dl>	
<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="StatProductAge/list.tpl"}
</div>