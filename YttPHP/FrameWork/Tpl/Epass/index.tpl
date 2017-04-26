{wz}
<form method="POST" action="{'Epass/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
				<dt>
					<label>{$lang.epass_no}：</label> 
					<input id="epass_no" name="like[epass_no]" value="{$smarty.post.like.epass_no}" url="{'/AutoComplete/epass'|U}" jqac> 
					</dt> 
					<dt>	
		<label>{$lang.state}：</label>
		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" combobox=1}
	</dt>
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="Epass/list.tpl"}
</div> 