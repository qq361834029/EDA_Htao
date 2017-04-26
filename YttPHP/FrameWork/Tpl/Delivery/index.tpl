{wz}
<form method="POST" action="{"Delivery/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
				{if $smarty.const.ACTION_NAME=='index'}
		  		<dt>
					<label >{$lang.delivery_no}：</label>
					<input type="text" name="pre_delivery[like][delivery_no]" url="{'/AutoComplete/deliveryNo'|U}" jqac>
            	</dt>  
            	{/if} 
            	<dt>
					<label >{$lang.sale_no}：</label>
					<input type="text" name="sale_order[like][orders_no]" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.client_name}：</label>
					<input type='hidden' name="pre_delivery[query][client_id]">
					<input type='text' url="{'/AutoComplete/client'|U}" jqac>
            	</dt> 
            	 
            	{if $smarty.const.ACTION_NAME=='index'}        			  
            	<dt>
					<label>{$lang.delivery_date_from}：</label>
						<input type="text" name="delivery[date][from_delivery_date]" value="{$smarty.post.date.from_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.delivery_date_to}</label>
						<input type="text" name="delivery[date][to_delivery_date]" value="{$smarty.post.date.to_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>  
            	{else}            
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="pre_delivery[date][from_pre_delivery_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="pre_delivery[date][to_pre_delivery_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>
            	{/if}            
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note tabs="delivery" content="<ul></ul>"}
<div id="print" class="width98"> 
{if $smarty.const.ACTION_NAME=='index'}
{include file="Delivery/list.tpl"} 
{else}
{include file="Delivery/waitdelivery.tpl"} 
{/if} 
</div> 

