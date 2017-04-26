{wz}
<form method="POST" action="{'Color/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
				<dt>
					<label>{$lang.color_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
					<input id="color_no" name="query[color_no]" value="{$smarty.post.query.color_no}" url="{'/AutoComplete/colorNo'|U}" jqac> 
					</dt>
					<dt>
					<label>{$lang.color_name}：</label> 
					<input id="color_name" name="query[color_name]" value="{$smarty.post.query.color_name}" url="{'/AutoComplete/colorName'|U}" jqac> 
					</dt>
					<dt>
					<label>{$lang.state}：</label>  
					{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" combobox=1 }
            	</dt>
			</dl> 
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="Color/list.tpl"}
</div> 
