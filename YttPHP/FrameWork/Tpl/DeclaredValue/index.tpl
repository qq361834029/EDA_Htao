{wz}
<form method="POST" action="{"DeclaredValue/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>		
		<dt>
			<label>{$lang.doc_date}{$lang.from_date}：</label>
			<input type="text" name="detail[date][needdate_from_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="detail[date][needdate_to_create_time]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	
        <dt>
        <label>{$lang.doc_staff}：</label>
        <input type="hidden" id="warehouse_id" name="detail[query][a.add_user]" >
        <input type="text"  url="{'/AutoComplete/BelongsaddUserRealName'|U}" jqac>
        </dt>
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note insert=true}
<div id="print" class="width98">
{include file="DeclaredValue/list.tpl"}
</div> 

