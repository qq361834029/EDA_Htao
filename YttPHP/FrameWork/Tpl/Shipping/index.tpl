{wz}
<form method="POST" action="{"Shipping/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
				<dt>
					<label>{$lang.shipping_no}：</label>
					<input type='text' name="main[like][express_no]" url="{'/AutoComplete/shippingNo'|U}" jqac>
            	</dt>   			
				<dt>
					<label>{$lang.shipping_name}：</label>
					<input type='text' name="main[like][express_name]" url="{'/AutoComplete/shipping'|U}" jqac>
            	</dt>   
				<dt>
					<label>{$lang.shipping_type}：</label>
					{select data=C('SHIPPING_TYPE') name="main[query][shipping_type]" combobox=1}
				</dt>				
				<dt>
					<label>{$lang.warehouse_name}：</label>
					<input type='hidden' name="main[query][warehouse_id]">
             		<input type='text' url="{'/AutoComplete/warehouseName'|U}" jqac>
            	</dt>    			
				<dt>
					<label>{$lang.express}：</label>
					<input type='hidden' name="main[query][company_id]">
             		<input type='text' url="{'/AutoComplete/expressName'|U}" jqac>
            	</dt>    
				{if !$is_factory}
            	<dt>
					<label>{$lang.is_enable}：</label>
					{select data=C('IS_ENABLE') initvalue={$smarty.post.main.query.status} name="main[query][status]" combobox=1}
            	</dt>         
				{/if}
                <dt>
					<label>{$lang.is_enable_volume}：</label>
					{select data=C('IS_ENABLE') initvalue={$smarty.post.main.query.calculation} name="main[query][calculation]" combobox=1}
            	</dt>  
		</dl>	
__SEARCH_END__
</form>
{note insert=!$is_factory}
<div id="print" class="width98">
{include file="Shipping/list.tpl"}
</div> 

