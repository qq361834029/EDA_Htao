{wz}
<form method="POST" action="{"StatInstock/{$smarty.const.ACTION_NAME}"|U}" id="search_form" onsubmit="return false;">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.factory_name}：</label>
					<input type="hidden" name="query[factory_id]" value="{$smaty.get.query.factory_id}">
					<input type="text" name="factory_name" url="{'/AutoComplete/factory'|U}" jqac>
            	</dt>
				<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="query[b.product_id]">
             		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
            	</dt>            			  
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_real_arrive_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
						<input type="text" name="date[to_real_arrive_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>    
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="StatInstock/list.tpl"}
</div> 

