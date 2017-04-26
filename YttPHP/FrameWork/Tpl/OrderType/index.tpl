{wz}
<form method="POST" action="{'OrderType/index'|U}" id="search_form">
__SEARCH_START__	
<dl>
	<dt>
		<label>{$lang.order_type}：</label>
        <input type="hidden" value="{$smarty.post.query.id}" name="query[id]">
		<input type="text" name="temp[order_type_name]" url="{'AutoComplete/orderTypeTag'|U}" value="{$smarty.post.temp.order_type_name}" jqac />
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
{include file="OrderType/list.tpl"}
</div> 
