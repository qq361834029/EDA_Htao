{wz}
<script>
	function changeVerify(obj){
		var parent	= $(obj).parents('dl:first');
		var ids		= ['factory_id', 'product_no'];
		if ($.trim($(obj).val()).length !== 0) {
			for (var i in ids) {
				$(parent).find('#' + ids[i]).removeClass('valid-required').parent().find('.font_red').html('');
			}
		} else {
			for (var i in ids) {
				$(parent).find('#' + ids[i]).addClass('valid-required').parent().find('.font_red').html('*');
			}
		}
	}
</script>
<form method="POST" action="{'StatProduct/view'|U}" beforeSubmit="checkSearchForm" validity="empty" id="search_form" >
<div style="padding-top:12px;"></div>
<div style="position: relative;padding-right:6px;">
__SEARCH_START__
	<dl> 
    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
        <dt>
            <label>{$lang.belongs_seller}：</label>
            <input type="hidden" id="factory_id" name="query[factory_id]" onchange="setFactory(this);" value="{$smarty.post.main.query.factory_id}" class="valid-required">
            <input id="factory_email" name="factory_email" value="{$smarty.post.temp.factory_email}" url="{'/AutoComplete/factoryEmail'|U}" jqac>__*__
        </dt> 
	{else}
		<input type="hidden" name="query[factory_id]" value="{$login_user.company_id}">
	{/if}
		<dt>
			<label>{$lang.product_no}：</label>
			<input name="like[product_no]" id='product_no' url="{'/AutoComplete/product'|U}" class="valid-required" jqac>__*__
		</dt>
		<dt>
			<label>{$lang.product_id}：</label>
            <input id="stat_p_id" type="text" autocomplete="off" name="query[id]" onchange="changeVerify($(this))" onkeyup="changeVerify($(this))" class="spc_input">
		</dt>
	</dl>

__SEARCH_END__
	</div>
</form>
<div id="print" class="width100">
{if $smarty.post.search_form}
{include file="StatProduct/list.tpl"}
{/if}
</div>