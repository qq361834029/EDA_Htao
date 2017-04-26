{wz}
<form method="POST" action="{"Delivery/{$smarty.const.ACTION_NAME}"|U}" id="search_form">   
__SEARCH_START__
		<dl>
				{if $smarty.const.ACTION_NAME=='index'}
		  		<dt>
					<label >{$lang.delivery_no}：</label>
					<input type="text" name="delivery[like][delivery_no]" url="{'/AutoComplete/deliveryNo'|U}" jqac>
            	</dt> 
            	<dt>
					<label >{$lang.sale_no}：</label>
					<input type="text" name="delivery[like][orders_no]" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
            	</dt> 
            	<dt>
					<label>{$lang.client_name}：</label>
					<input type='hidden' name="delivery[query][client_id]">
					<input type='text' url="{'/AutoComplete/client'|U}" jqac>
            	</dt> 
            	{else}
            	<dt>
					<label >{$lang.sale_no}：</label>
					<input type="text" name="sale_order[like][sale_order_no]" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.client_name}：</label>
					<input type='hidden' name="sale_order[query][client_id]">
					<input type='text' url="{'/AutoComplete/client'|U}" jqac>
            	</dt>  
            	{/if}   
            	{if $smarty.const.ACTION_NAME=='index'}        			  
            	<dt>
					<label>{$lang.delivery_date_from}：</label>
						<input type="text" name="delivery[date][from_delivery_date]" 	class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.delivery_date_to}</label>
						<input type="text" name="delivery[date][to_delivery_date]" 	class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>  
            	{else}            
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="sale_order[date][from_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="sale_order[date][to_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>
            	{/if}            
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note tabs="delivery" content="<ul></ul>"}
<div id="print" class="width98">

{if $smarty.const.ACTION_NAME=='index'} 
{include file="DeliverySale/list.tpl"} 
{else}
{include file="DeliverySale/waitdelivery.tpl"} 
{/if} 
</div> 

