{wz}
<form method="POST" action="{'Size/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
				<dt>
					<label>{$lang.size_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
					<input id="size_no" name="query[size_no]" value="{$smarty.post.query.size_no}" url="{'/AutoComplete/sizeNo'|U}" jqac> 
					</dt>
					<dt>
					<label>{$lang.size_name}：</label> 
					<input id="size_name" name="query[size_name]" value="{$smarty.post.query.size_name}" url="{'/AutoComplete/sizeName'|U}" jqac> 
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
{include file="Size/list.tpl"}
</div>
