{if $verifyType!='1'}
{literal}
<script type="text/javascript">
$dom.find("#barcode").focus();
$dom.find("input[jqac]").each(function(){$(this).initAutocomplete();});
$dom.find("select[combobox]").each(function(){$(this).combobox();});
$dom.find("form[id!='search_form']").sendForm();
var detail_list = $('.detail_list');
if(detail_list){
	detail_list.bandCache();
	detail_list.bandTotalMethod();//明细表绑定合计事件
	detail_list.bandProductMethod();//明细表绑定合计事件
}
$dom.find('.list').tableClick(); 
if(detail_list){
	var options = {target: $dom.find("#print:first"),success:searchSuccess};
	options['beforeSubmit'] = function(){
	    $dom.find("#_page_qtp").remove();
	    $.loading();
	};
}
$("#tips").fadeOut(100);
$.removeLoading();
</script>
{/literal}
{/if}
{if $product_id>0}
<script type="text/javascript">
    autoQuantityPlus('{$product_id}');
</script>
{/if}
{if $rs.sale_order_state == C('SALE_ORDER_DELETED')}
    {assign var='color' value='style="background:#FFFFE0;"'}
{/if}
<form action="{'SaleOrder/update'|U}" method="POST" beforeSubmit="checkSaleaState">
<div class="add_box" {$color}>
{if $rs.sale_order_state == C('SALE_ORDER_DELETED')}{*已删除订单不显示复制*}
    {wz action='save,reset' button=true save_name='submit'}
{else}
    {if $rs.express_enable_print==1}
        {if $rs.out_stock_type==1}
            {wz action='save,save_print,reset,print_waybill' button=true save_name='ship'}
        {elseif $rs.out_stock_type>1}
            {wz action='save,save_print,temp,reset,print_waybill' button=true save_name='ship'}
        {/if}
    {else}
        {if $rs.out_stock_type==1}
            {wz action='save,reset,print_waybill' button=true save_name='ship'}
        {elseif $rs.out_stock_type>1}
            {wz action='save,temp,reset,print_waybill' button=true save_name='ship'}
        {/if}       
    {/if}
{/if}
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
	<tr><th><input type="hidden" name="mac_address" id="mac_address" value="" class="spc_input">
			<div class="titleth">
				<div class="titlefl">{$lang.basic_info}</div>
                    <div class="afr">
                        {$lang.deal_no}：{$rs.sale_order_no}
                        {if $rs.sale_order_state != C('SALE_ORDER_DELETED')}{*已删除订单不显示复制*}
                            <input style="width:50px;" type="button" class="button_new" value="{L('copy')}" id="d_clip_button_{$rs.id}" 
                            data-clipboard-target="sale_order_no_{$rs.id}" />
                        {/if}
                    </div>
			</div>
	</th></tr> 
	<tr><td><div class="basic_tb">
		<ul> 
			<input type="hidden" value="{$rs.sale_order_no}" id="sale_order_no_{$rs.id}"/>
			<input type="hidden" name="id" id="id" value="{$rs.id}"/>  
			<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
			{if $rs.out_stock_type>0}
			<input type="hidden" name="out_stock_type" id="out_stock_type" value="{$rs.out_stock_type}"/>  
			{/if}
			<input type="hidden" name="verifyType" value="{$verifyType}">
			<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}">
			<input type="hidden" name="from_type" id="from_type" value="out_stock">
			<input type="hidden" name="flow" id="flow" value="sale">
			<input type="hidden" name="order_type" id='order_type' value="{$rs.order_type}">
			<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}">
			<input type="hidden" name="is_registered" id='is_registered' value="{$rs.is_registered}">
			<li>{$lang.orderno}：{$rs.new_order_no}
				<input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}">
			</li>
			<li>{$lang.order_date}：{$rs.fmd_order_date}
				<input type="hidden" name="order_date"  id="order_date" value="{$rs.fmd_order_date}">
			</li> 
			<li>{$lang.express_way}：{$rs.ship_name}
				<input type="hidden" name="express_id" id='express_id' onchange="getExpressInfo();" value="{$rs.express_id}">
				<img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
			</li>
            {if $rs.shipping_type==C('SHIPPING_TYPE_SURFACE')}
            <li class="afr">
                {$lang.delivery_costs}:{$rs.expected_delivery_costs}
            </li>
            {/if}
			<li>{$lang.track_no}：
				<input type="text" name="track_no" id='track_no' value="{$rs.track_no}" {if $rs.Labelurl}class="spc_input disabled" readonly="readonly"{else}class="spc_input"{/if}>
			</li>
			<li>{$lang.package}：
                <input type="hidden" id="package_id" onchange="weightByPackage(this)" name="package_id" value="{$rs.package_id}">
				<input type="text" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={$rs.warehouse_id}"  value="{$rs.package_name}" jqac />
			</li>
			<li>{$lang.sale_order_state}：
                {if $rs.sale_order_state == C('SALE_ORDER_DELETED')}{*已删除订单只能作废*}
                    {assign var='initvalue' value=C('SALEORDER_OBSOLETE')}
                    {assign var='filter' value=C('SALE_ORDER_OUT_INFO_FILTER_DELETED')}
                {else}
                    {assign var='initvalue' value=C('SHIPPED')}
                    {assign var='filter' value=C('SALE_ORDER_OUT_INFO_FILTER')}
                {/if}
			{select data=C('SALE_ORDER_STATE') name="sale_order_state" id='sale_order_state' onchange='changeSaveTitle(this)' combobox='' empty=true initvalue=$initvalue filter=$filter}
			__*__
			</li>
			<li>{$lang.total_weight}：
                <span id="total_weight">{$rs.detail_total.s_unit_weight}</span>
			</li>
			{if $rs.is_registered==1}
			<li class="red">{$lang.is_registered}：
				<span id="is_registered">{$rs.dd_is_registered}</span>
			</li>
			{/if}
            <li id="aliexpress"  {if $rs.order_type != C('ALIEXPRESS')}style="display: none;"{/if}>
                {$lang.aliexpress_token}：
                {$rs.aliexpress_token}
		<input type="hidden" name="aliexpress_token" value="{$rs.aliexpress_token}" />
            </li>
            <li {if $rs.is_insure==1}style="color:red;font-weight:bolder;"{/if}>
                {$lang.insure}：
                {$rs.dd_is_insure}
            </li>
            {if $rs.is_insure==1}
                <li>{$lang.insure_price}：
                    <input type="text" name="insure_price" id='insure_price' value="{$rs.edml_insure_price}" class="spc_input">{$rs.w_currency_no}
                </li>
            {/if}
		</ul>
	</div></td></tr>   
	<tr><th>
		{$lang.sale_order_info}&nbsp;&nbsp;&nbsp;
		{if $verifyType=='1'}
		{$lang.product_id}：<input type="text" name="input_product_id" id='input_product_id' value="" class="spc_input">
		<span class="tred" id="input_product_id_error"></span>
		{/if}
	</th></tr>   
	<tr><td>{include file="SaleOrder/outStockDetail.tpl"}</td></tr>
	<tr><td>&nbsp;</td></tr>   
	<tr><th>{$lang.client_info}</th></tr> 
	<tr><td>
		<table width="80%" cellspacing="0" cellpadding="0" border="0">
		<input type="hidden" value="{$rs.company_name}" id='company_name' name="addition[1][company_name]">
		<input type="hidden" value="{$rs.consignee}" id='consignee' name="addition[1][consignee]">
		<input type="hidden" value="{$rs.transmit_name}" id='transmit_name' name="addition[1][transmit_name]">
		<input type="hidden" value="{$rs.country_id}" id="country_id" name="addition[1][country_id]">
		<input type="hidden" value="{$rs.city_name}" id="city_name" name="addition[1][city_name]">
		<input type="hidden" value="{$rs.country_name}" id="country_name" name="addition[1][country_name]">
		<input type="hidden" value="{$rs.tax_no}" id='tax_no' name="addition[1][tax_no]">
		<input type="hidden" value="{$rs.email}" id='email' name="addition[1][email]">
		<input type="hidden" value="{$rs.edit_address}" id="address" name="addition[1][address]">
		<input type="hidden" value="{$rs.edit_address2}" id="address2" name="addition[1][address2]">
		<input type="hidden" value="{$rs.post_code}" id='post_code' name="addition[1][post_code]">
		<input type="hidden" value="{$rs.mobile}" id='mobile' name="addition[1][mobile]">
		<input type="hidden" value="{$rs.fax}" id='fax' name="addition[1][fax]">
		<input type="hidden" value="{$rs.addition_id}"  name="addition[1][id]">
		
		<tbody>
			<tr>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						

						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left">{$rs.consignee}</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left">{$rs.transmit_name}</td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
								{$rs.country_name} {$rs.abbr_district_name} 
							</td>
						</tr>
						<tr>
							<td>{$lang.belongs_city}：</td>
							<td class="t_left">
								{$rs.city_name}
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left">{$rs.email}</td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left">{$rs.tax_no}</td>
						</tr>
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left">{$rs.edit_address}</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left">{$rs.edit_address2}</td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left">{$rs.company_name}</td>
						</tr>
						
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left">{$rs.post_code}</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left">{$rs.mobile}</td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left">{$rs.fax}</td>
						</tr>
                        {if $rs.gallery}
						<tr>
							<td>{$lang.download_file}：</td>  
                            <td class="t_left">
                                {foreach $rs.gallery as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                    </div>
                                {/foreach}
                            </td>                  
						</tr>
						{/if}
					</tbody>
				</table>
				</td>
				
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td id='out_stock_comments'>{$lang.comments}：</td>
							<td class="t_left"><textarea id="comments" name="comments" >{$rs.edit_comments}</textarea></td>
						</tr>
					</tbody>
				</table>
				</td>
			</tr>
		</tbody>
		</table>
	</td></tr>                      
   </tbody>          
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

<script type="text/javascript">
	//复制
	var clip_object = new ZeroClipboard( $dom.find("#d_clip_button_{$rs.id}"), {
		moviePath: "__PUBLIC__/Js/ZeroClipboard/ZeroClipboard.swf"
	} );

	clip_object.on( 'complete', function(client, args) {
		noticeInfo("复制成功，复制内容为："+ args.text);
	} );

</script>
<script>
	$(document).ready(function(){
		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$dom.find('#mac_address'));
	});
</script>