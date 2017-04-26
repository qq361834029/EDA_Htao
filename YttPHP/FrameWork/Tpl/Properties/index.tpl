{wz}
<form method="POST" action="{'Properties/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
				<dt>
					<label>{$lang.properties_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
					<input id="properties_no" name="query[properties_no]" value="{$smarty.post.query.properties_no}" url="{'/AutoComplete/propertiesNo'|U}" jqac> 
					</dt>
					<dt>
					<label>{$lang.properties_name}：</label> 
					<input id="properties_name" name="query[properties_name]" value="{$smarty.post.query.properties_name}" url="{'/AutoComplete/propertiesName'|U}" jqac> 
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
{include file="Properties/list.tpl"}
</div> 