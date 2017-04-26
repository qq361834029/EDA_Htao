{wz}
<form method="POST" action="{'User/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
	<dt>
	<label>{$lang.user_name}：</label>
	<input type="text" name="like[user_name]" class="spc_input ac_input" url="{'/AutoComplete/user'|U}" jqac>
	</dt>
	<dt>
	<label>{$lang.user_type}：</label>
       {select data=C('CFG_USER_TYPE') name="query[user_type]" id="user_type" value="`$smarty.post.query.user_type`" combobox=1}  			
	</dt>
	<dt>
	<label>{$lang.state}：</label>
    {select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" combobox=1 initvalue=1}
    </dt>
</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="User/list.tpl"}
</div> 
