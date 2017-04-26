{wz}
<form method="POST" action="{'SkuKeywords/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	<dt><label>{$lang.id}：</label>
		<input value="{$smarty.post.main.query.id}" name="query[id]" type='text' class="spc_input">
	</dt>		
	<dt><label>{$lang.product_no}：</label>
		<input id="product_no" name="like[product_no]" value="{$smarty.post.like.product_no}" url="{'/AutoComplete/skuKeywords'|U}" jqac>
	</dt>
    <dt><label>{$lang.state}：</label>
	{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="-2" combobox=1}
	</dt>
</dl>
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="SkuKeywords/list.tpl"}
</div>  