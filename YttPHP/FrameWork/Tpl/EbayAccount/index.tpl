{wz}
<form method="POST" action="{'EbayAccount/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.ebay_account}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
			<input type="text" name="like[user_id]" class="spc_input ac_input" url="{'AutoComplete/ebayUser'|U}" jqac />
		</dt>
		
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input type="hidden" value="{$smarty.post.query.factory_id}" name="query[factory_id]" id="factory_id" value="{$fac_id}">
			<input type="text" value="{$fac_name}" class="spc_input ac_input" url="{'/AutoComplete/factory'|U}" jqac>
		</dt>
		{/if}	
	</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="EbayAccount/list.tpl"}
</div> 