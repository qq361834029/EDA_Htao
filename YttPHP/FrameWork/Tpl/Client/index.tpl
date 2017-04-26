{wz}
<form method="POST" action="{'Client/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
	<dt>
		<label>{$lang.belongs_seller}：</label>
		<input type="hidden" name="query[factory_id]" value="{$smarty.post.query.factory_id}">
		<input type="text" name="factory_name" value="{$smarty.post.factory_name}" url="{'AutoComplete/factory'|U}" jqac />
	</dt>
	{/if}
	<dt>
		<label>{$lang.clientname}：</label>
		<!--input type="hidden" name="query[id]" value="{$smarty.post.query.id}">
		<input type="text" name="client_name" value="{$smarty.post.client_name}" url="{'AutoComplete/buyer'|U}" jqac /-->
		<input value="{$smarty.post.like.comp_name}" type='text' name="like[comp_name]" class="spc_input">
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
</dl>
__SEARCH_END__
</form> 
{note export=true insert=true}
<div id="print" class="width98">
{include file="Client/list.tpl"}
</div> 