{wz}
<form method="POST" action="{'SellerStaff/index'|U}" id="search_form">
__SEARCH_START__
<dl>	
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
	<dt>
		<label>{$lang.belongs_seller}：</label>
		<input type="hidden" value="{$smarty.post.query.company_id}" name="query[company_id]" id="company_id" value="{$fac_id}">
		<input type="text" value="{$fac_name}" class="spc_input ac_input" url="{'/AutoComplete/factory'|U}" jqac>
	</dt>
	{/if}	
	
	<dt>
		<label>{$lang.email}：</label>
		<input type="text" value="{$smarty.post.like.user_name}" name="like[user_name]" class="spc_input ac_input" url="{'/AutoComplete/userSellerStaffEmail'|U}" jqac>
	</dt>
	<dt>
		<label>{$lang.employee_name}：</label>
		<input type="text" value="{$smarty.post.like.real_name}" name="like[real_name]" class="spc_input ac_input" url="{'/AutoComplete/userSellerStaff'|U}" jqac>
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
{include file="SellerStaff/list.tpl"}
</div> 
