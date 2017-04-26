{wz}
<br>
<form method="POST" action="{"SaleOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form" beforesubmit="checkSearchForm" >
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.custom_barcode}：</label>
			<input id="custom_barcode" value="" name="query[custom_barcode]" value="{$smarty['post']['query']['p.custom_barcode']}" type='text' class="spc_input valid-required">__*__
		</dt>  
		<dt>
			<label>{$lang.warehouse_name}：</label>
			{if $w_id > 0}
				<input type="hidden" name="query[warehouse_id]" value="{$w_id}">
				<input name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" value="{$w_name}" disabled="disabled" class="spc_input disabled" />	
			{else}
            <input id="warehouse_id" value="{$smarty['post']['query']['warehouse_id']}" type="hidden" name="query[warehouse_id]" onchange="getExpressCompany(this)" class="valid-required">
            <input id="warehouse_name" value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
					
			{/if}
		</dt>
		<dt>
			<label>{$lang.pick_no}：</label>
			<input id="custom_barcode" value="" name="query[pick_no]" value="{$smarty['post']['query']['pick_no']}" type='text' class="spc_input valid-required">__*__
		</dt>  
{*        <dt>
			<label>{$lang.shipping_type}：</label>
			{select data=C('SHIPPING_TYPE') name="query[e.shipping_type]" value="{$smarty['post']['query']['e.shipping_type']}" empty=true combobox=1}
        </dt>        
        <dt>
        <label>{$lang.express}：</label>
        <span id="company">
            <input type="hidden" name="query[e.company_id]" id="company_id" value="{$smarty['post']['query']['e.company_id']}">
            <input type="text" name="temp[company_name]" value="{$smarty.post.temp.company_name}" id="company_name" url="{'/AutoComplete/companyUse'|U}" where="1" jqac/>
        </span>
        </dt>
        <dt>
            <label>{$lang.express_way}：</label>
            <input value="{$smarty['post']['query']['a.express_id']}" type="hidden" name="query[a.express_id]" >
            <input value="{$smarty.post.temp.express_name}" name="temp[express_name]" type='text' url="{'/AutoComplete/shipping'|U}" jqac>
        </dt>
		<dt>
		 <label>{$lang.order_type}：<label>
            <input type="hidden" id="order_type" name="query[a.order_type]" value="{$smarty['post']['query']['a.order_type']}" />
            <input url="{'AutoComplete/orderTypeTag'|U}" value="" class="spc_input" jqac/>
		</dt>  
        <dt>
		 <label>{$lang.order_type_change}：<label>
            {select data=C('YES_NO') value=0 name="order_type_change" initvalue=$smarty['post']['order_type_change'] empty_value=false combobox='1'}
		</dt>
        <dt>
		 <label>{$lang.is_registered}：<label>
            {select data=C('YES_NO') value=0 name="is_registered" initvalue=$smarty['post']['is_registered'] empty_value=false combobox='1'}
		</dt>
        <dt>
		 <label>{$lang.out_stock_type}：<label>
            {select data=C('SALE_ORDER_OUT_STOCK_TYPE') value=$smarty.post.out_stock_type name="out_stock_type"  initvalue='-2' combobox=''}
		</dt>*}
	</dl>	
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>

<div id="print" class="width98">
{if $rs.id>0&&$rs.out_stock_type>0}
{include file='SaleOrder/outStockInfo.tpl'}
{/if}
</div>

<script type="text/javascript">
{if $verifyType=='1'}
$dom.find("#barcode").focus();
{else}
$dom.find("#custom_barcode").focus();
{/if}
</script>