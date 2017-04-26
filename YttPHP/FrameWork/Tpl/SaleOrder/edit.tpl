<form action="{'SaleOrder/update'|U}" method="POST" beforeSubmit="checkSaleaState">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
	<tr>
		<th>
			<div class="titleth">
			<div class="titlefl">{$lang.basic_info}</div>
			<div class="afr">{$lang.deal_no}：{$rs.sale_order_no}</div>
			</div>
		</th>
	</tr> 
	<tr><td><div class="basic_tb">
		<ul> 
			<input type="hidden" name="id" id="id" value="{$rs.id}"/> 
			<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
			<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}">
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}">
			<input type="hidden" name="flow" id="flow" value="sale">
			<input type="hidden" name="transaction_id" id='transaction_id' value="{$rs.transaction_id}">
            {if $sale_order_deleted}
                    <li>
                        {$lang.orderno}：   
                        {$rs.order_no}<input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input"></li>
                    <li>
                        {$lang.belongs_seller}：
                        {$rs.factory_name}
                    </li>
                    <li>
                        {$lang.clientname}：
                        {$rs.client_name}
                    </li>
                    <li>
                        {$lang.sale_date}： 
                        {$rs.fmd_order_date}
                        <input type="hidden" name="order_date" id="order_date" value="{$rs.fmd_order_date}" class="spc_input">
                    </li>
                    <li>
                        {$lang.order_type}：
                        {$rs.order_type_name}
                        <input type="hidden" name="order_type" id='order_type' onchange="aliexpress(this)"  value="{$rs.order_type}" class="spc_input">
                    </li>
                    <li id="aliexpress"  {if $rs.order_type != C('ALIEXPRESS')}style="display: none;"{/if}>
                        {$lang.aliexpress_token}：
                        <input type="text"  id='aliexpress_token' value="{$rs.aliexpress_token}" name="aliexpress_token" class="spc_input">__*__
                    </li>
                    <li>{$lang.shipping_warehouse}：
                        <input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" onchange="getExpressWayEdit(this)" class="spc_input">
                        {$rs.w_name}
                    </li> 
                    <li>{$lang.express_way}：
                            <input type="hidden" id="express_id" name="express_id" onchange="getExpressInfoEdit();" value="{$rs.express_id}">
                                {$rs.ship_name}
                    </li>					
                    <li>{$lang.express_date}：
                            {$rs.ship_date}
                    </li>
					{if $rs.company_id== C('EXPRESS_BRT_ID') && $rs.warehouse_id== C('EXPRESS_IT_WAREHOUSE_ID')}
					<li id="brt_li">{$lang.brt_account_no}：
    					 {$rs.brt_account_no}
						 <input  type="hidden" id='flag' value="1">
					</li>
					{/if}
					<li id="brt_li_none" style="display: none;">{$lang.brt_account_no}：
    					 {$rs.brt_account_no}
					</li>
                    <li>
                        {$lang.is_registered}：
                        <input type="hidden" name="is_registered" id='is_registered' value="{$rs.is_registered}" class="spc_input">
                        {$rs.dd_is_registered}
                    </li>
                    <li>{$lang.track_no}：
                            {$rs.track_no}
                    </li>
                {else}
                {if $login_user.role_type==C('SELLER_ROLE_TYPE')}
                    {if $rs.sale_order_state==C('ERROR_ADDRESS')}
                    <li>
                        {$lang.orderno}： {$rs.order_no}
                        <input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input">
                    </li>
                    <li>{$lang.clientname}：{$rs.client_name} 
                    <li>{$lang.sale_date}：{$rs.fmd_order_date}
                        <input type="hidden" name="order_date"  id="order_date" value="{$rs.fmd_order_date}" class="Wdate spc_input"/>
                    </li> 
                    <li>{$lang.order_type}：{$rs.order_type_name}
                        <input type="hidden" name="order_type"  id="order_type" value="{$rs.order_type}" class="Wdate spc_input"/>
                    </li> 
                    {if $rs.order_type == C('ALIEXPRESS')}
                    <li>
                        {$lang.aliexpress_token}：{$rs.aliexpress_token}
                        <input type="hidden"  id='aliexpress_token' value="{$rs.aliexpress_token}" name="aliexpress_token" class="spc_input">
                    </li>
                    {/if}
                    <li>{$lang.shipping_warehouse}：{$rs.w_name}
                        <input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" class="spc_input">
                    </li> 
                    <li>{$lang.express_way}：{$rs.ship_name}
                            <input type="hidden" id="express_id" name="express_id" value="{$rs.express_id}">
                    </li>					
                    <li>{$lang.express_date}：{$rs.ship_date}
                            <input type="hidden" id='express_date' name='express_date' value="{$rs.ship_date}" class="spc_input ">
                    </li>
					{if $rs.company_id== C('EXPRESS_BRT_ID')&& $rs.warehouse_id== C('EXPRESS_IT_WAREHOUSE_ID')}
					<li id="brt_li">{$lang.brt_account_no}：
    					<input readonly type="text" id='brt_account_no' class="spc_input disabled"  value="{$rs.brt_account_no}">
						<input  type="hidden" id='flag' value="1">
					</li>
					{/if}
					<li id="brt_li_none" style="display: none;">{$lang.brt_account_no}：
    					 <input readonly type="text" id='brt_account_no_none' class="spc_input disabled"  value="{$rs.brt_account_no}">
					</li>
                    <li>
                        {$lang.is_registered}：{$rs.dd_is_registered}
                        <input type="hidden" name='is_registered' value="{$rs.is_registered}" class="spc_input ">
                    </li>
                        {else}
                    <li>
                        {$lang.orderno}： {$rs.order_no}
                        <input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input">
                    </li>
                    <li>{$lang.clientname}：{$rs.client_name} 
                    <li>{$lang.sale_date}：
                    <input type="text" name="order_date"  id="order_date" value="{$rs.fmd_order_date}" class="Wdate spc_input" 
                    {if 'digital_format'|C==eur}
                    {literal} 
                    onClick="WdatePicker({dateFmt:'dd/MM/yy'})"
                    {/literal}
                    {else}
                    {literal} 
                    onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                    {/literal}
                    {/if}
                    />__*__</li> 
                    <li>{$lang.order_type}：
                        <input type="hidden" name="order_type" id='order_type' value="{$rs.order_type}" class="spc_input" onchange="aliexpress(this)">
                        <input type='text' name="order_type_name" id='order_type_name' value="{$rs.order_type_name}" url="{'/AutoComplete/orderType'|U}" jqac>__*__
                    </li> 
                    <li id="aliexpress"  {if $rs.order_type != C('ALIEXPRESS')}style="display: none;"{/if}>
                        {$lang.aliexpress_token}：
                        <input type="text"  id='aliexpress_token' value="{$rs.aliexpress_token}" name="aliexpress_token" class="spc_input">__*__
                    </li>
                    {if in_array($rs.sale_order_state,explode(',',C('SALE_CAN_ADD_STATE')))}{*卖家可以修改仓库和派送方式的状态*}
						<li>{$lang.shipping_warehouse}：
							<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" onchange="getExpressWayEdit(this)" class="spc_input">
							{if in_array($rs.sale_order_state, array(C('SALE_ORDER_STATE_EDITING')))}
								<input type='text' name="w_name" id='w_name' value="{$rs.w_name}" url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
							{else}
								{$rs.w_name}
							{/if}
						</li>
                        <li>{$lang.express_way}：
                            <span id="express_way">
                                <input type="hidden" id="express_id" name="express_id" onchange="getExpressInfoEdit();" value="{$rs.express_id}">
                                    <input type="text" name="temp[ship_name]" url="{'AutoComplete/shippingUse'|U}" where="{"warehouse_id='`$rs.warehouse_id`'"|urlencode}" value="{$rs.ship_name}" jqac />
                            </span>__*__
                            <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
                        </li>
                    {else}
                        <li>{$lang.shipping_warehouse}：
                            <input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" onchange="getExpressWayEdit(this)" class="spc_input">
                            {$rs.w_name}
                        </li> 
                        <li>{$lang.express_way}：
                            <span id="express_way">
                                <input type="hidden" id="express_id" name="express_id" onchange="getExpressInfoEdit();" value="{$rs.express_id}">
                                    {$rs.ship_name}
                            </span>
                            <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
                        </li>
                    {/if}					
                    <li>{$lang.express_date}：
                            <input readonly type="text" id='express_date' value="{$rs.ship_date}" class="spc_input disabled">
                    </li>
					{if $rs.company_id== C('EXPRESS_BRT_ID') && $rs.warehouse_id== C('EXPRESS_IT_WAREHOUSE_ID')}
					<li id="brt_li">{$lang.brt_account_no}：
    					<input readonly type="text" id='brt_account_no' class="spc_input disabled"  value="{$rs.brt_account_no}">
						<input  type="hidden" id='flag' value="1">
					</li>
					{/if}
					<li id="brt_li_none" style="display: none;">{$lang.brt_account_no}：
    					<input readonly type="text" id='brt_account_no_none' class="spc_input disabled"  value="{$rs.brt_account_no}">
					</li>
                    <li>
                        {$lang.is_registered}：
                        {if in_array($rs.express_id,explode(',',C('EXPRESS_FR_REGISTERED_ID')))}
                           <input id="is_registered" type="radio" checked="" value="1" name="is_registered">{$lang.yes}
                           <input id="is_not_registered" type="radio"  value="2" name="is_registered"  disabled>{$lang.no}
                        {else}
                            {if $rs.is_registered==1}
                             <input id="is_registered" type="radio" checked="" value="1" name="is_registered">{$lang.yes}
                             <input id="is_not_registered" type="radio"  value="2" name="is_registered" >{$lang.no}   
                            {else}
                             <input id="is_registered" type="radio" value="1" name="is_registered" >{$lang.yes}
                             <input id="is_not_registered" type="radio" checked="" value="2" name="is_registered" >{$lang.no}
                            {/if}
                        {/if}
                    </li>
                    {/if}
                {else}
                    <li>{$lang.orderno}：   {$rs.order_no}<input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input"></li>
                    <li>{$lang.belongs_seller}：{$rs.factory_name}</li>
                                    <li>{$lang.clientname}：{$rs.client_name}</li>
                    <li>{$lang.sale_date}： {$rs.fmd_order_date}<input type="hidden" name="order_date" id="order_date" value="{$rs.fmd_order_date}" class="spc_input"></li>
                    <li>{$lang.order_type}：{$rs.order_type_name}<input type="hidden" name="order_type" id='order_type' value="{$rs.order_type}" class="spc_input"></li>	
                    {if $rs.order_type == C('ALIEXPRESS')}
                    <li>
                        {$lang.aliexpress_token}：{$rs.aliexpress_token}
                        <input type="hidden"  id='aliexpress_token' value="{$rs.aliexpress_token}" name="aliexpress_token" class="spc_input">
                    </li>
                    {/if}
                    <!--li>{$lang.shipping_warehouse}：{$rs.w_name}<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" class="spc_input">
                    </li> 
                    <li class="w320">{$lang.express_way}：{$rs.ship_name}
                            <input type="hidden" name="express_id" id='express_id' onchange="getExpressInfo();" value="{$rs.express_id}" class="spc_input">
                        <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
                    </li>
                    <li>{$lang.express_date}：{$rs.ship_date}</li-->

                    <li>{$lang.shipping_warehouse}：
                        <input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}" onchange="getExpressWayEdit(this)" class="spc_input">
                        <input type='text' name="w_name" id='w_name' value="{$rs.w_name}" url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
                    </li> 
                    <li>{$lang.express_way}：
                        <span id="express_way">
                            <input type="hidden" id="express_id" name="express_id" onchange="getExpressInfoEdit();" value="{$rs.express_id}">
                                <input type="text" name="temp[ship_name]" url="{'AutoComplete/shippingUse'|U}" where="{"warehouse_id='`$rs.warehouse_id`'"|urlencode}" value="{$rs.ship_name}" jqac />
                        </span>__*__
                        <img pid="{$rs.express_id}" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
                    </li>
                    <li>{$lang.express_date}：
                            <input readonly type="text" id='express_date' value="{$rs.ship_date}" class="spc_input disabled">
                    </li>
					{if $rs.company_id== C('EXPRESS_BRT_ID') && $rs.warehouse_id== C('EXPRESS_IT_WAREHOUSE_ID')}
					<li id="brt_li">{$lang.brt_account_no}：
						<input readonly type="text" id='brt_account_no' class="spc_input disabled"  value="{$rs.brt_account_no}">
						<input  type="hidden" id='flag' value="1">
					</li>
					{/if}
					<li id="brt_li_none" style="display: none;">{$lang.brt_account_no}：
    				<input readonly type="text" id='brt_account_no_none' class="spc_input disabled"  value="{$rs.brt_account_no}">
					</li>

                    <li>
                        {$lang.is_registered}：
                        <input type="hidden" name="is_registered" id='is_registered' value="{$rs.is_registered}" class="spc_input">
                        {$rs.dd_is_registered}
                    </li>
                    <li>{$lang.track_no}：
                            <input type="text" name="track_no" id='track_no' value="{$rs.track_no}" class="spc_input">
                    </li>
                {/if}
            {/if}
			{if $login_user.role_type!=C('SELLER_ROLE_TYPE') && $rs.sale_order_state == C('SHIPPED')}
				<li>{$lang.package}：
					<input type="hidden" id="package_id" name="package_id" value="{$rs.package_id}">
					<input type="text" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}"  where="warehouse_id={$rs.warehouse_id}" value="{$rs.package_name}" jqac />
				</li>			
			{/if}
			<li>{$lang.sale_order_state}：
                {if $rs.sale_order_state == C('SALE_ORDER_DELETED')}{*状态已删除限编辑成已作废 added yyh 20150515*}
                    {assign var='sale_order_state_allow' value=C('DELETED_CAN_EDIT_STATE')}
                {else}
                    {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
                        {if in_array($rs.sale_order_state, explode(',', C('ADMIN_SHIPPED_CAN_EDIT_STATE')))}
                            {if  $rs.sale_order_state == C('SALE_ORDER_POST_OFFICE_RETURNED') && $count_return > 0}
                                {assign var='sale_order_state_allow' value=C('SALE_ORDER_POST_OFFICE_RETURNED')}
                                {else}
                                {assign var='sale_order_state_allow' value=C('ADMIN_SHIPPED_CAN_EDIT_STATE')}
                                {/if}
                        {elseif $is_sent && $rs.sale_order_state == C('SALEORDER_OBSOLETE')}
                            {assign var='sale_order_state_allow' value=C('SALEORDER_OBSOLETE')}
                        {else}
                            {assign var='sale_order_state_allow' value=C('ADMIN_CAN_EDIT_STATE')}
                            {assign var='sale_order_state_filter' value=C('ADMIN_SHIPPED_CAN_EDIT_STATE')}
                        {/if}
                    {else}
                        {if in_array($rs.sale_order_state, array(C('SALE_ORDER_STATE_PICKING'), C('SALE_ORDER_STATE_PICKED')))}
                            {assign var='sale_order_state_allow' value=$rs.sale_order_state}
                        {elseif $is_sent==1 && $rs.sale_order_state==C('ERROR_ADDRESS')}
                            {assign var='sale_order_state_allow' value=C('ERROR_OBSOLETE')}
                        {else}
                            {assign var='sale_order_state_allow' value=C('SELLER_CAN_EDIT_STATE')}
                            {assign var='sale_order_state_filter' value={C('SALE_ORDER_STATE_PICKING')|cat:',':C('SALE_ORDER_STATE_PICKED')}}
                        {/if}
                    {/if}
                {/if}
                {select data=C('SALE_ORDER_STATE') name="sale_order_state" id='sale_order_state' value=$rs.sale_order_state combobox='' empty=true filter=$sale_order_state_filter allow=$sale_order_state_allow}__*__
            </li> 
			{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
			<li>{$lang.comment}：
				<input type="text" name="state_log_comments" id='state_log_comments' class="spc_input">
			</li> 
			{/if}
            <li>{$lang.insure}：
                {if $rs.sale_order_state==C('SALE_ORDER_STATE_PENDING')}
                    {radio data=C('IS_INSURE') name="is_insure" initvalue=$rs.is_insure}
                {else}
                    {$rs.dd_is_insure}
                {/if}
            </li>
            {if ($is_sent || $rs.sale_order_state==C('SALEORDER_OBSOLETE')) && $rs.is_insure==1 && $rs.sale_order_state==C('SHIPPED')}
                <li>{$lang.insure_price}：
                    <input type="text" name="insure_price" id='insure_price' value='{$rs.edml_insure_price}' class="spc_input">{$rs.w_currency_no}
                </li>
            {elseif $is_sent && $rs.is_insure==1}
                <li>{$lang.insure_price}：
                    {$rs.dml_insure_price}
                </li>  
            {/if}
		</ul>
	</div></td></tr>   
	<tr><th>{$lang.sale_order_info}</th></tr>   
	<tr><td>{include file="SaleOrder/detail.tpl"}</td></tr>
	<tr><th>{$lang.client_info}<input type="hidden" id="city_name_flag" value="1"></th></tr>   
	<tr><td>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<input value="{$rs.addition_id}" type="hidden" name="addition[1][id]">
		<tbody>
			<tr>
				{if $login_user.role_type==C('SELLER_ROLE_TYPE') && $is_sent==1 && !$sale_order_deleted}
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left"><input value="{$rs.consignee}" type="text" name="addition[1][consignee]" id='consignee' class="spc_input">__*__</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left"><input value="{$rs.transmit_name}" type="text" name="addition[1][transmit_name]" id='transmit_name' class="spc_input"></td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
								<input type="text" id="country_name" value="{$rs.country_name}" name="addition[1][country_name]" class="spc_input">
								<input type="hidden" name="addition[1][country_id]" value="{$rs.country_id}" id="country_id" class="spc_input">
								<input id="full_country_name" value="{$rs.full_country_name}" url="{'AutoComplete/country'|U}" jqac >__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.belongs_city}：</td>
							<td class="t_left">
								<input type="text" name="addition[1][city_name]" value="{$rs.city_name}" class="spc_input">__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left"><input value="{$rs.email}" type="text" name="addition[1][email]" id='email' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left"><input value="{$rs.tax_no}" type="text" name="addition[1][tax_no]" id='tax_no' class="spc_input"></td>
						</tr>
                        {if $rs.gallery}
                        <tr>
                            <td>{$lang.download_file}：</td>                           
                            <td class="t_left">
                                {foreach $rs.gallery as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                        <a onclick="$.deleteFile({$val.id})" href="javascript:;">
                                            <img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
                                        </a>
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
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left"><input value="{$rs.edit_address}" type="text" name="addition[1][address]" id="address" class="spc_input" >__*__</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left"><input value="{$rs.edit_address2}" type="text" name="addition[1][address2]" id="address2" class="spc_input" ></td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left"><input value="{$rs.company_name}" type="text" name="addition[1][company_name]" id='company_name' class="spc_input"></td>
						</tr>
						
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left"><input value="{$rs.post_code}" type="text" name="addition[1][post_code]" id='post_code' class="spc_input">__*__</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left"><input value="{$rs.mobile}" type="text" name="addition[1][mobile]" id='mobile' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left"><input value="{$rs.fax}" type="text" name="addition[1][fax]" id='fax' class="spc_input"></td>
						</tr>
                        <tr>
								<td>{$lang.upload_file}：</td>
								<td class="t_left">{upload tocken=$file_tocken sid=$sid type=19 allowTypes="all"}</td>
								<input type="hidden" id="file_name" name="file_name">
								<input type="hidden" name="sheet" value="0">
								<input type="hidden" name="import_key" value="{$import_key}">
						</tr>
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td>{$lang.comments}：</td>
							<td class="t_left"><textarea id="comments" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
						</tr>
					</tbody>
				</table>
				</td>
				{else}
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left">
							<input value="{$rs.consignee}" type="hidden" name="addition[1][consignee]" id='consignee' class="spc_input">{$rs.consignee}</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left">
							<input value="{$rs.transmit_name}" type="hidden" name="addition[1][transmit_name]" id='transmit_name' class="spc_input">{$rs.transmit_name}</td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
							<input type="hidden" id="country_id" value="{$rs.country_id}" name="addition[1][country_id]" class="spc_input">
							<input type="hidden" id="country_name" name="addition[1][country_name]" value="{$rs.country_name}" class="spc_input">{$rs.country_name} {$rs.abbr_district_name}
							</td>
						</tr>
						<tr>
							<td>{$lang.belongs_city}：</td>
							<td class="t_left">
							<input type="hidden" id="city_name" name="addition[1][city_name]" value="{$rs.city_name}">{$rs.city_name}</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left"><input value="{$rs.email}" type="hidden" name="addition[1][email]" id='email' class="spc_input">{$rs.email}</td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left"><input value="{$rs.tax_no}" type="hidden" name="addition[1][tax_no]" id='tax_no' class="spc_input">{$rs.tax_no}</td>
						</tr>
						{if $rs.gallery}
                        <tr>
                            <td>{$lang.download_file}：</td>                           
                            <td class="t_left">
                                {foreach $rs.gallery as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                        {if ($login_user.role_type!=C('SELLER_ROLE_TYPE') || $rs.sale_order_state!=C('ERROR_ADDRESS')) && $rs.sale_order_state != C('SALE_ORDER_DELETED') }
                                        <a onclick="$.deleteFile({$val.id})" href="javascript:;">
                                            <img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
                                        </a>
                                        {/if}
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
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left"><input value="{$rs.edit_address}" type="hidden" name="addition[1][address]" id="address" class="spc_input" >{$rs.edit_address}</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left"><input value="{$rs.edit_address2}" type="hidden" name="addition[1][address2]" id="address2" class="spc_input" >{$rs.edit_address2}</td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left">
							<input value="{$rs.company_name}" type="hidden" name="addition[1][company_name]" id='company_name' class="spc_input">{$rs.company_name}</td>
						</tr>
						
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left"><input value="{$rs.post_code}" type="hidden" name="addition[1][post_code]" id='post_code' class="spc_input">{$rs.post_code}</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left"><input value="{$rs.mobile}" type="hidden" name="addition[1][mobile]" id='mobile' class="spc_input">{$rs.mobile}</td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left"><input value="{$rs.fax}" type="hidden" name="addition[1][fax]" id='fax' class="spc_input">{$rs.fax}</td>
						</tr>
                        {if ($login_user.role_type!=C('SELLER_ROLE_TYPE') || $rs.sale_order_state!=C('ERROR_ADDRESS')) && $rs.sale_order_state != C('SALE_ORDER_DELETED') }
						<tr>
								<td>{$lang.upload_file}：</td>
								<td class="t_left">{upload tocken=$file_tocken sid=$sid type=19 allowTypes="all"}</td>
								<input type="hidden" id="file_name" name="file_name">
								<input type="hidden" name="sheet" value="0">
								<input type="hidden" name="import_key" value="{$import_key}">
						</tr>
                        {/if}
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td>{$lang.comments}：</td>
							<td class="t_left"><textarea id="comments" class="disabled textarea_height80" name="comments" readonly>{$rs.edit_comments}</textarea></td>
						</tr>
					</tbody>
				</table>
				</td>
				{/if}
			</tr>
		</tbody>
		</table>
       </td></tr>                      
   </tbody>          
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 