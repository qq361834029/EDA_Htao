{wz}
<form method="POST" action="{"ReturnService/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
			<dt>
				<label>{$lang.return_service_no}：</label>
				<input type='text' name="main[like][return_service_no]" url="{'/AutoComplete/returnServiceNo'|U}" jqac>
			</dt>   			
			<dt>
				<label>{$lang.return_service_name}：</label>
				<input type='text' name="main[like][return_service_name]" url="{'/AutoComplete/returnServiceName'|U}" jqac>
			</dt>    			
			{if !$is_factory}
			<dt>
				<label>{$lang.is_enable}：</label>
				{select data=C('IS_ENABLE') initvalue={$smarty.post.main.query.status} name="main[query][status]" combobox=1}
				</dt>         
			{/if}
		</dl>	
__SEARCH_END__
</form>
{note insert=!$is_factory}
<div id="print" class="width98">
{include file="ReturnService/list.tpl"}
</div> 

