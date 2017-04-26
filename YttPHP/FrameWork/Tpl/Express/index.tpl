{wz}
<form method="POST" action="{'Express/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl> 
	<dt>
		<label>{$lang.express_name}：</label>
		<input type="text" name="like[comp_name]" value="{$smarty.post.like.comp_name}" url="{'AutoComplete/expressName'|U}" jqac />
	</dt>
	<dt>
		<label>{$lang.belongs_country}：</label>
		<input type="hidden" name="query[country_id]" value="{$smarty.post.query.country_id}">
		<input type="text" name="country_name" value="{$smarty.post.country_name}" url="{'AutoComplete/countryName'|U}" jqac />
	</dt>
	<dt>
		<label>{$lang.belongs_city}：</label>
		<input type="text" name="query[city_name]" value="{$smarty.post.query.city_name}" class="spc_input"/>
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
{include file="Express/list.tpl"}
</div> 