{wz}
{if C('SHOW_MANY_BASIC')==1}
<form method="POST" action="{'Basic/index'|U}" id="search_form">
__SEARCH_START__	
<dl> 
	<dt>
		<label>{$lang.basic_name}：<input type="hidden" id="rand" name="rand" value="{$rand}">
</label>
		<input type="text" name="like[basic_name]" url="{'AutoComplete/companyName'|U}" value="{$smarty.post.like.basic_name}" jqac />
	</dt> 
	<dt>
		<label>{$lang.state}：</label>
        {select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
	</dt>
</dl> 
__SEARCH_END__
</form>
{else}
{searchForm}
{/if} 
{if C('SHOW_MANY_BASIC')==1}
	{note export=true}
{else}
	{note}
{/if}
<div id="print" class="width98">
{include file="Basic/list.tpl"}
</div> 