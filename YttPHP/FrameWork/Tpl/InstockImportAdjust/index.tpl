{wz}
<form method="POST" action="{"InstockImportAdjust/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.adjust_no}：</label>
			<input value="{$smarty.post.main.like.adjust_no}" type="text" name="main[like][adjust_no]" url="{'/AutoComplete/instockAdjustNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.box_id}：</label>
			<input value="{$smarty.post.detail.query.box_id}" name="detail[query][box_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.detail.query.product_id}" name="detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>	
		<dt>
			<label>{$lang.doc_date}{$lang.from_date}：</label>
			<input type="text" name="main[date][needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InstockImportAdjust/list.tpl"}
</div> 

