{wz}
<form method="POST" action="{'PropertiesValue/index'|U}" id="search_form">
__SEARCH_START__
			<dl>   
            	<dt>
					<label>{$lang.pv_no}：</label>
					<input id="pv_no" name="like[pv_no]" value="{$smarty.post.like.pv_no}" url="{'/AutoComplete/pvNo'|U}" jqac>
				</dt>
				<dt>
					<label>{$lang.pv_name}：</label>
					<input id="pv_name" name="like[pv_name]" value="{$smarty.post.like.pv_name}" url="{'/AutoComplete/pvName'|U}" jqac>
            	</dt>
            	<dt>	
					<label>{$lang.state}：</label>
            		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
				</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="PropertiesValue/list.tpl"}
</div> 
