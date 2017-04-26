{wz}
<form method="POST" action="{'Package/index'|U}" id="search_form">
__SEARCH_START__	
<dl> 
    <dt>
		<label>{$lang.belongs_warehouse}：</label>
        <input type="hidden" name="query[warehouse_id]" value="{$smarty.post.query.warehouse_id}">
        <input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$smarty.post.query.w_name}" jqac />
    </dt>
	<dt>
		<label>{$lang.package_name}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
		<input type="text" name="like[package_name]" url="{'AutoComplete/packageName'|U}" value="{$smarty.post.like.package_name}" jqac />
	</dt> 
	<dt>
		<label>{$lang.state}：</label>
		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
	</dt>
</dl> 
__SEARCH_END__
</form>
{note export=true insert=!$is_factory}
<div id="print" class="width98">
{include file="Package/list.tpl"}
</div> 