{wz}
<form method="POST" action="{'MessageCategory/index'|U}" id="search_form">
__SEARCH_START__
			<dl>
				<dt>
					<label>{$lang.category_no}：</label>
					<input id="category_no" name="query[category_no]" value="{$smarty.post.category_no}" url="{'/AutoComplete/categoryNo'|U}" jqac>
					</dt>
					<dt>
					<label>{$lang.category_name}：</label>
					<input id="category_name" name="query[category_name]" value="{$smarty.post.category_name}" url="{'/AutoComplete/categoryName'|U}" jqac>
					</dt>
					<dt>
					<label>{$lang.state}：</label>
					{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.to_hide`" initvalue="1" combobox=1}
            	</dt>
			</dl>
__SEARCH_END__
</form>
{note insert=true}
<div id="print" class="width98">
{include file="MessageCategory/list.tpl"}
</div> 