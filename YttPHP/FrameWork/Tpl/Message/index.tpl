{wz}
<form method="POST" action="{'Message/index'|U}" id="search_form" >
__SEARCH_START__
			<dl>
			<dt>
				<label>{$lang.category_name}：</label>
				<input type="hidden" name="query[message_category_id]" id="message_category_id" >
				<input id="category_name" name="category[category_name]" value="{$smarty.post.category.category_name}" url="{'/AutoComplete/categoryId'|U}" jqac>
			</dt>

			<dt>
				<label>{$lang.message_title}：</label>
				<input id="message_title" name="query[message_title]" value="{$smarty.post.query.message_title}" url="{'/AutoComplete/messageTitle'|U}" jqac>
			</dt>
			<dt>
				<label>{$lang.query_according_period}：</label>
				<input type="text" name="from_paid_date" class="Wdate spc_input_data" onClick="WdatePicker()"/>
				<label>{$lang.to_date}</label>
				<input type="text" name="to_paid_date" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			</dt>
            {if $is_admin}
			<dt>
				<label>{$lang.user_type}：</label>
				{select data=C('CFG_USER_TYPE') name="user_type"   value="`$smarty.post.query.user_type`" combobox='' empty=true}
			</dt>
			{/if}
            {if !$super_admin}
                <dt>
                    <label>{$lang.is_read}：</label>  
                    <input name="is_read" id="s_yes" type="radio" value="1">{$lang.yes}
                    <input name="is_read" id="s_no" type="radio" value="2"{if $smarty.get.is_read ==2} checked {/if} >{$lang.no}
                </dt>
            {/if}
			</dl>
__SEARCH_END__
</form>
{note insert=$is_admin}
<div id="print" class="width98">
{include file="Message/list.tpl"}
</div> 