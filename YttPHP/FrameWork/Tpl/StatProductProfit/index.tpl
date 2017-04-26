{wz}
{if $smarty.get.search_div!=2}
<form method="POST" action="{'StatProductProfit/index'|U}" id="search_form">
__SEARCH_START__
<dl>
	<dt>
		<label >{$lang.product_no}：</label>
		<input id="id" type="hidden" value="" name="query[a.id]">
		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=1}
	<dt>
		<label>{$lang.class_name_1}：</label>
		<input type="hidden" name="query[class_1]">
		<input id="pv_no" name="class_1"  url="{'/AutoComplete/ProductClass1'|U}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=2}
	<dt>
		<label>{$lang.class_name_2}：</label>
		<input type="hidden" name="query[class_2]">
		<input id="pv_no" name="class_2"  url="{'/AutoComplete/ProductClass2'|U}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=3}
	<dt>
		<label>{$lang.class_name_3}：</label>
		<input type="hidden" name="query[class_3]">
		<input id="pv_no" name="class_3" url="{'/AutoComplete/ProductClass3'|U}" jqac>
	</dt>
	{if C('PRODUCT_CLASS_LEVEL')>=4}
	<dt>
		<label>{$lang.class_name_4}：</label>
		<input type="hidden" name="query[class_4]">
		<input id="pv_no" name="class_4" url="{'/AutoComplete/ProductClass4'|U}" jqac>
	</dt>
	{/if}
	{/if}
	{/if}
	{/if}   
	 <dt class="w320">
		<label>{$lang.from_date}：</label>
		<input type="text" name="from_date" value="{$smarty.post.from_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="to_date" value="{$smarty.post.to_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
	 </dt>   			
</dl>	
<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{else}
{searchForm}
{/if}
{note}
<div id="print" class="width98">
{include file="StatProductProfit/list.tpl"}
</div> 

