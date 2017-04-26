{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
    {if in_array($rs.sale_order_state,array(1,2))}
        {assign var="action" value=['add','edit']}
        {else}
        {assign var="action" value=['add']}
    {/if}
{assign var="deal_state" value=['sale_order_state'=>C('SALE_ORDER_DETAIL_VIEW_STATE_SELLER')]}
{else}
{assign var="action" value=['add']}
{assign var="deal_state" value=['sale_order_state'=>C('SALE_ORDER_DETAIL_VIEW_STATE')]}
{/if}
{assign var="splitPackage" value=['sale_order_state'=>C('SALE_ORDER_DETAIL_SPLIT_PACKAGE')]}
{detail_table id=detail_table flow='sale' from=$rs.detail action=['view'] op_show=$action
	thead=['p_id',$lang.product_no,$lang.custom_barcode,$lang.product_name,$lang.import_sku,$lang.sale_quantity,$lang.express_way,$lang.package_bg,$lang.weight_detail,$lang.spec_detail]}
<tr index="{$index}" class="{$none}" >
	<input type="hidden" name="detail[{$index}][id]" value="{$item.id}"> 
	{td type="p_id" id="span_product_id" view="product_id" width="" class="t_left"}
	 {$item.product_id}
	{/td}
	{td viewstate=$deal_state id="span_product"  view="product_no" width="160" class="t_left"}
		<input type="hidden" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" jqproc class="w200">
		<input type="text" name="temp[{$index}][product_no]" value="{$item.product_no}" url="{'AutoComplete/product'|U}" jqac class="w200{if !$rs && $login_user.role_type!=C('SELLER_ROLE_TYPE')} disabled {/if}" {if !$rs && $login_user.role_type!=C('SELLER_ROLE_TYPE')} disabled {/if} {$readonly}>
	{/td}
	{td  id="span_custom_barcode" view="custom_barcode" width="160" class="t_left"}
	  {$item.custom_barcode}
	{/td}
	{td id="span_product_name" view="product_name" width="320" class="t_left"}
	 {$item.product_name}
	{/td}
	{td type="import_sku" id="import_sku" view="import_sku" width="160" class="t_left"}
		{$item.import_sku}
	{/td}
	{td viewstate=$deal_state type="flow_quantity" view="dml_quantity" width="56" tfoot=[total_quantity=>""]  tfoot_value="{$rs.detail_total.dml_quantity}" tfoot_id="total_quantity" class="t_right"}
		<input type="text" name="detail[{$index}][quantity]" class="w50" id="quantity" value="{$item.edml_quantity}" row_total {$readonly}>
	{/td}
    {td viewstate=$splitPackage  view="ship_name" width="90" class="t_right"}
        <span id="express_way">
                <input type="hidden" id="express_id" name="detail[{$index}][express_id]" onchange="getDetailExpressInfo();" value="{$rs.express_id}">
                <input type="text" name="temp[ship_name]" url="{'AutoComplete/shippingUse'|U}" where="{"warehouse_id='`$rs.warehouse_id`'"|urlencode}" value="{$rs.ship_name}" jqac {$readonly}>
        </span>
        <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
    {/td}
	{td  type="package_bg" view="package_bg" width="56" class="t_right"}
        {if in_array($rs.sale_order_state,explode(',',C('SALE_CAN_ADD_STATE'))) || $smarty.const.ACTION_NAME == 'add'}
            <input type="text" name="detail[{$index}][package_bg]" class="w50" id="package_bg" value="{$item.package_bg}">
        {else}
            <input type="text" name="detail[{$index}][package_bg]" class="w50 disabled" readonly id="package_bg" value="{$item.package_bg}">
        {/if}
    {/td}
    {if C('IS_PRODUCT_TYPE')}
        {td viewstate=$splitPackage  view="ship_name" width="90" class="t_right"}
            <span id="express_way">
                {if $rs.express_id}
                    <input type="hidden" id="express_id" name="detail[{$index}][express_id]" onchange="getDetailExpressInfo();" value="{$rs.express_id}">
                    <input type="text" name="temp[ship_name]" url="{'AutoComplete/shippingUse'|U}" where="{"warehouse_id='`$rs.warehouse_id`'"|urlencode}" value="{$rs.ship_name}" jqac {$readonly}>
                {/if}
            </span>
            <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
        {/td}
        {td  viewstate=$splitPackage view="package_bg" class="t_right" width="56"}
			{if $rs.disabled_package == 1}
				{$rs.package_bg}
			{else}
				<input type="text" name="detail[{$index}][package_bg]" class="w50" id="package_bg" value="{$rs.package_bg}" {$readonly} >
			{/if}
        {/td}
    {/if}
	{td width="90" type="flow_row_total" view="dml_quantity" tfoot=[total_col_qn=>""] tfoot_value="{$rs.detail_total.dml_quantity}"  total_row_qn="" class="t_right"}
		{$item.edml_quantity}
	{/td}
	{td id="span_product_weight" tfoot=[total_col_weight=>""] total_row_weight="" tfoot_value="{$rs.detail_total.s_weight}" width="150" class="t_right"}
		{$item.s_weight}
	{/td}
	<input type="hidden" id="weight" value="{$item.weight}" weight> 
	{td id="span_product_cube" tfoot=[total_col_cube=>""] total_row_cube="" width="320" tfoot_value="{$rs.detail_total.s_cube}" class="t_right"}
		{$item.s_cube}
	{/td}
	<input type="hidden" id="cube_long" value="{$item.cube_long}">
	<input type="hidden" id="cube_wide" value="{$item.cube_wide}">
	<input type="hidden" id="cube_high" value="{$item.cube_high}"> 
	{detail_operation}
</tr>
{/detail_table}
