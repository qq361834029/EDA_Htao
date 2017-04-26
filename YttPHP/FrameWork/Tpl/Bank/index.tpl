{wz}
<form method="POST" action="{'Bank/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
				<dt>
					<label>{$lang.pay_bank}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
            		<input name="like[account_name]" type="text" url="{'/AutoComplete/accountName'|U}" jqac>
            		</dt>
				<dt><label>{$lang.bank_name}：</label>
					<input name="like[bank_name]" type="text"  url="{'/AutoComplete/bankName'|U}" where="{"to_hide=1 "|urlencode}" jqac>
            		</dt>
				{if $admin}
				<dt><label>{$lang.state}：</label>
            		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
				</dt>
				{else}
					<input type="hidden"  name="query[to_hide]" value="1"/>
				{/if}
			</dl> 
__SEARCH_END__
</form>
{note export=true insert=($admin===true)}
<div id="print" class="width98">
{include file="Bank/list.tpl"}
</div> 
