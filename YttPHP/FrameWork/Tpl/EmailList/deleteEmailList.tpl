{wz}
<form method="POST" action="{"EmailList/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
		<dt>
			<label>{$lang.email_type}：</label>
			{select data=C('EMAIL_TYPE') name='query[email_type]' id='email_type' value="`$smarty.post.query.email_type`" combobox="1"}
		</dt>
		<dt>
			<label>{$lang.comp_name}：</label>
			<input type='hidden' name="query[comp_id]">
			<input type='text' url="{'/AutoComplete/allCompany'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.flow_no}：</label>
			<input type='text' name="query[object_no]" url="{'/AutoComplete/flowNo'|U}" jqac>
		</dt>
	</dl>
__SEARCH_END__
</form>
{note tabs="emailList"}
<div id="print" class="width98">
{include file="EmailList/delete.tpl"}
</div> 