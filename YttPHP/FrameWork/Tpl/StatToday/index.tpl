{wz}
<form method="POST" action="{"StatToday/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>         			  
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_paid_date]" class="Wdate spc_input_data" value="{$smarty.post.date.from_paid_date}" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
						<input type="text" name="date[to_paid_date]" class="Wdate spc_input_data" value="{$smarty.post.date.to_paid_date}" onClick="WdatePicker()"/>
            	</dt>  
            	<dt>
					<label>{$lang.show_all_funds}：</label>
					 <input type="radio" name="show" value="1" {if $smarty.post.show ==1} checked {/if}>{$lang.yes} <input type="radio" name="show" value="0"  {if !$smarty.post.show} checked {/if}>{$lang.no}
            	</dt>    
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="StatToday/list.tpl"}
</div> 

