{wz}
<form method="POST" action="{'Role/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
	<dt>
	<label>{$lang.role_name}：</label>
	<input type="text" name="like[role_name]" value="" class="spc_input ac_input" url="{'/AutoComplete/role'|U}" jqac>
	</dt>
</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="Role/list.tpl"}
</div> 
