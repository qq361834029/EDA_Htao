{wz}
<form method="POST" action="{"DomesticShippingFee/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
                <dt>
                    <label>{$lang.belongs_warehouse}：</label>
                    <input type="hidden" name="query[warehouse_id]" value="{$smarty.post.query.warehouse_id}">
                    <input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$smarty.post.query.w_name}" jqac />
                </dt>
				<dt>
					<label>{$lang.shipping_fee_no}：</label>
					<input type="hidden" name="query[id]" />
					<input type='text' name="temp[domestic_shipping_fee_no]" url="{'/AutoComplete/domesticShippingFeeNo'|U}" jqac>
            	</dt>   			
				<dt>
					<label>{$lang.shipping_fee_name}：</label>
					<input type='text' name="like[domestic_shipping_fee_name]" url="{'/AutoComplete/domesticShippingFee'|U}" jqac>
            	</dt>   
				<dt>
					<label>{$lang.transport_type}：</label>
					{select data=C('TRANSPORT_TYPE') name="query[transport_type]" combobox=1}
				</dt>
                <dt>
                    <label>{$lang.state}：</label>
                    {select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
                </dt>
		</dl>	
__SEARCH_END__
</form>
{note  insert=($admin===true)}
<div id="print" class="width98">
{include file="DomesticShippingFee/list.tpl"}
</div> 

