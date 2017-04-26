{wz}
<form method="POST" action="{'Product/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
	<dt>
		<label>{$lang.belongs_seller}：</label>
		<input type="hidden" name="main[query][a.factory_id]" value="{$smarty.post.main.query.factory_id}">
		<input id="factory_email" name="temp[factory_email]" value="{$smarty.post.temp.factory_email}" url="{'/AutoComplete/factoryEmail'|U}" jqac>
	</dt> 
	{else}
		<input type="hidden" name="main[query][a.factory_id]" value="{$login_user.company_id}">
	{/if}
	<dt><label>{$lang.id}：</label>
		<input value="{$smarty.post.main.query.id}" name="main[query][a.id]" type='text' class="spc_input">
	</dt>		
	<dt><label>{$lang.product_no}：</label>
		<input id="product_no" name="main[like][a.product_no]" value="{$smarty.post.main.like.product_no}" url="{'/AutoComplete/productNo'|U}" jqac>
	</dt>
	<dt><label>{$lang.product_name}：</label>
		<input id="product_no" name="main[like][a.product_name]" value="{$smarty.post.main.like.product_name}" url="{'/AutoComplete/productName'|U}" jqac>
	</dt>
	<dt><label>{$lang.custom_barcode}：</label>
		<input id="custom_barcode" name="main[like][a.custom_barcode]" value="{$smarty.post.main.like.custom_barcode}" url="{'/AutoComplete/productCustomBarcode'|U}" jqac>
	</dt>
	<dt><label>{$lang.product_pics}：</label>
	{select data=C('YES_NO') name="pics" value=$smarty.post.pics combobox=1}
	</dt>
	<dt><label>{$lang.state}：</label>
	{select data=C('BASICSTATE') name="main[query][a.to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
	</dt>
    <dt><label>{$lang.check_status}：</label>
	{select data=C('CHECK_STATUS') name="main[query][a.check_status]" value="`$smarty.post.query.check_status`"  combobox=1}
	</dt>
</dl>
__SEARCH_END__
</form> 
{note export=true exportBarcode=true}
<div id="print" class="width98">
{include file="Product/list.tpl"}
</div>  