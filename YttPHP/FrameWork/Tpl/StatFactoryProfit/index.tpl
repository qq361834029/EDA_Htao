{wz}
{if $smarty.get.search_div!=2}
<form method="POST" action="{'StatFactoryProfit/index'|U}" id="search_form">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.factory_name}：</label>
					<input id="id" type="hidden" value="" name="query[id]">
             		<input type='text' url="{'/AutoComplete/factory'|U}" jqac>
            	</dt>
				 <dt class="w320">
					<label>{$lang.from_date}：</label>
					<input type="text" name="from_date" value="{$smarty.post.from_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
					<label>{$lang.to_date}</label>
					<input type="text" name="to_date" value="{$smarty.post.to_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
				 </dt>   			
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{/if}
{note}
<div id="print" class="width98">
{include file="StatFactoryProfit/list.tpl"}
</div> 

