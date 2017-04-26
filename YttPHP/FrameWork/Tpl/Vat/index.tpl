{wz}
<form method="POST" action="{'Vat/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>
	{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
	<dt>
		<label>{$lang.factory_name}：</label>
		<input type="hidden" name="query[factory_id]" value="{$smarty.post.query.factory_id}">
		<input type="text" name="comp_name" value="{$smarty.post.comp_name}" url="{'AutoComplete/factory'|U}" jqac />
	</dt>
	{/if}
	{if $login_user.role_type!=C('WAREHOUSE_ROLE_TYPE')}
	<dt>
		<label>{$lang.belongs_country}：</label>
		<input type="hidden" name="query[country_id]" value="{$smarty.post.query.country_id}">
		<input type="text" name="country_name" value="{$smarty.post.country_name}" url="{'AutoComplete/countryName'|U}" jqac />
	</dt>
	{/if}
</dl>
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="Vat/list.tpl"}
</div> 