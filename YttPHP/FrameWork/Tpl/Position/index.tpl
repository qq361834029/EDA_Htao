{wz}
<form method="POST" action="{'Position/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
	<dt>
		<label>{$lang.position_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
		<input type="text" name="like[position_no]" url="{'AutoComplete/positionNo'|U}" jqac />
	</dt>
	<dt>
		<label>{$lang.position_name}：</label> 
		<input type="text" name="like[position_name]" url="{'AutoComplete/positionName'|U}" jqac />
	</dt> 
	<dt>	
		<label>{$lang.state}：</label>
        {select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
	</dt>
</dl> 
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="Position/list.tpl"}
</div>  