{wz}
<form method="POST" action="{'Factory/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>
	<dt>
		<label>{$lang.id}：</label>
		<input value="{$smarty.post.query.id}" name="query[id]" type='text' class="spc_input">
	</dt>	
	<dt>
		<label>{$lang.email}：</label>
		<input name="query[email]" type='hidden' class="spc_input">
		<input type="text" name="temp[email]" value="{$smarty.post.like.email}" url="{'AutoComplete/factoryNameEmail'|U}" jqac />
	</dt>	
	<dt>
		<label>{$lang.factory_name}：</label>
		<input type="text" name="like[comp_name]" value="{$smarty.post.tmp.comp_name}" url="{'AutoComplete/factoryName'|U}" jqac />
	</dt>
	<dt>
		<label>{$lang.phone}：</label>
		<input type="text" name="like[mobile]" value="{$smarty.post.like.mobile}" url="{'AutoComplete/factoryMobile'|U}" jqac />
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
		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" combobox=1}
	</dt>
</dl>
__SEARCH_END__
</form> 
{note export=true}
__SCROLL_BAR_START__
<div id="print" class="width98">
{include file="Factory/list.tpl"}
</div> 
__SCROLL_BAR_END__