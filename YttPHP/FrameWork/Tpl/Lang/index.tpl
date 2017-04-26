{wz}
<form method="POST" action="{'Lang/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
	<dt>
		<label>{$lang.module}：</label>
		<input type="hidden" name="query[module]" value="{$smarty.post.query.module}" >
		<input type="text" name="module_name" value="{$smarty.post.module_name}" url="{'AutoComplete/langModuleForClient'|U}" jqac />
	</dt>
	<dt>
		<label>{'SYSTEM_LANG.cn'|C}：</label>
		<input type="text" name="like[lang_value_cn]" value="{$smarty.post.like.lang_value_cn}" class="spc_input"/>
	</dt>
	<dt>
		<label>{'SYSTEM_LANG.de'|C}：</label>
		<input type="text" name="like[lang_value_de]" value="{$smarty.post.like.lang_value_de}" class="spc_input">
	</dt>
</dl> 
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="Lang/list.tpl"}
</div> 