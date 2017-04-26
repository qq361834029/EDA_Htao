{wz}
<form method="POST" action="{"PreDelivery/{$smarty.const.ACTION_NAME}"|U}" id="search_form"> 
__SEARCH_START__
		<dl>
				{if $smarty.const.ACTION_NAME=='index'}
		  		<dt>
					<label >{$lang.pre_delivery_no}：</label>
					<input type="text" name="main[like][pre_delivery_no]" url="{'/AutoComplete/preDeliveryNo'|U}" jqac>
            	</dt>
            	<dt>
					<label >{$lang.sale_no}：</label>
					<input type='hidden' name="main[query][sale_order_id]">
					<input type="text" name="pre_delivery_no" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.client_name}：</label>
					<input type='hidden' name="main[query][client_id]">
					<input type='text' url="{'/AutoComplete/client'|U}" jqac>
            	</dt> 
            	<dt>
						<label>{$lang.pre_delivery_date_from}：</label>
							<input type="text" name="main[date][from_pre_delivery_date]" value="{$smarty.post.date.from_pre_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
								<label>{$lang.pre_delivery_date_to}</label>
							<input type="text" name="main[date][to_pre_delivery_date]" value="{$smarty.post.date.to_pre_delivery_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
	            	</dt> 
            	{else}
            	<dt>
					<label >{$lang.sale_no}：</label>
					<input type='hidden' name="main[query][id]">
					<input type="text" name="pre_delivery_no" url="{'/AutoComplete/saleOrderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.client_name}：</label>
					<input type='hidden' name="main[query][client_id]">
					<input type='text' url="{'/AutoComplete/client'|U}" jqac>
            	</dt> 
            	<dt>
						<label>{$lang.from_date}：</label>
							<input type="text" name="main[date][from_order_date]" value="{$smarty.post.date.from_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
								<label>{$lang.to_date}</label>
							<input type="text" name="main[date][to_order_date]" value="{$smarty.post.date.to_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
	            	</dt>  
            	{/if}           
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note tabs="preDelivery" content="<ul></ul>"}
<div id="print" class="width98"> 
{if $smarty.const.ACTION_NAME=='index'} 
{include file="PreDelivery/list.tpl"} 
{else}
{include file="PreDelivery/waitpredelivery.tpl"} 
{/if}
</div> 

