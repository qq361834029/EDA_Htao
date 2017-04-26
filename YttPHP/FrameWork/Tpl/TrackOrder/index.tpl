{wz}
<form method="POST" action="{"TrackOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
<input type="hidden" id="flow" value="trackOrderImport">
__SEARCH_START__
	<dl>
		<dt>
        {if $smarty.const.ACTION_NAME neq 'exportSaleOrderList'}
           <label>{$lang.import_time}：</label>
        {else}
			<label>{$lang.export_time}：</label>
        {/if}
			<input type="text" name="date[needdate_from_insert_date]" value="{$smarty.post.date.needdate_from_insert_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="date[needdate_to_insert_date]" value="{$smarty.post.date.needdate_to_insert_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		</dt>  
		<dt>
			<label>{$lang.operate_person}：</label>
			<input value="{$smarty.post.query.add_user}" type='hidden' name="query[add_user]">
			<input value="{$smarty.post.temp.real_name}" name="temp[real_name]" type='text' url="{'/AutoComplete/addUserRealNameCommon'|U}" jqac>
		</dt> 
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note }
<div id="print" class="width98">
{include file="TrackOrder/list.tpl"}
</div> 