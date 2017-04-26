<form action="{'SaleOrder/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
	<tr><th>{$lang.basic_info}</th></tr>
	<tr>
		<td>
		<div class="basic_tb">
			<ul>
			<input type="hidden" name="flow" id="flow" value="sale">
				<li>
					{$lang.orderno}： 
					<input type="text" name="order_no" id='order_no' class="spc_input">__*__
				</li>
                                {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                                <li>{$lang.belongs_seller}：
                                  <input type="hidden" name="factory_id" id="factory_id" onchange="getClientByFactory(this);setFacProduct(this);getBrtAccountNoByFactory(this);" value="">
                                  <input id="factory_name" name="temp[factory_name]" value="" url="{'/AutoComplete/factoryEmail'|U}" jqac>__*__
                                </li>    
                                {else}
                                        <input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
                                {/if}                                
				<li class="w320">
					{$lang.clientname}： 
					<input type="hidden" name="client_id" id="client_id" onchange="getClientInfo();">
					<input type="text" name="client_name" id='client_name' url="{'/AutoComplete/buyer'|U}" jqac>__*__
					{quicklyAdd module="Client" lang="add_client"}
				</li>
				<li>{$lang.sale_date}：
					<input type="text" name="order_date"  id="order_date" value="{$this_day}" class="Wdate spc_input" 
					{if 'digital_format'|C==eur}
					{literal} 
					onClick="WdatePicker({dateFmt:'dd/MM/yy'})"
					{/literal}
					{else}
					{literal} 
					onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
					{/literal}
					{/if}
				/>__*__
				</li> 
				<li>{$lang.order_type}：
                    <input type="hidden" name="order_type" id='order_type' class="spc_input" onchange="aliexpress(this)">
					<input type='text' name="order_type_name" id='order_type_name' url="{'/AutoComplete/orderType'|U}" jqac>__*__
				</li> 
                
                <li id="aliexpress" style="display: none;">
                    {$lang.aliexpress_token}：
                    <input type="text" id='aliexpress_token' name="aliexpress_token" class="spc_input">__*__
				</li>
				</li> 
				<li>{$lang.shipping_warehouse}：
					<input type="hidden" name="warehouse_id" id='warehouse_id' class="spc_input" onchange="getExpressWay(this);setSaleDetail(this);">
					<input type='text' name="warehouse_name" id='warehouse_name' url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
				</li> 
				<li class="w320">{$lang.express_way}：
					<span id="express_way">{L('select_express_way')}</span>
					__*__
					<img pid="" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
				</li>			
				<li>{$lang.express_date}：
    					<input readonly type="text" id='express_date' class="spc_input disabled">
				</li>
				<li style="display: none;" id="brt_li">{$lang.brt_account_no}：
    					<input readonly type="text" id='brt_account_no' class="spc_input disabled">
				</li>
				<li>{$lang.is_registered}：
					<input id="is_registered" type="radio" value="1" name="is_registered" >{$lang.yes}
                    <input id="is_not_registered" type="radio" checked="" value="2" name="is_registered" >{$lang.no}
				</li>
				<!--
				{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}  
				<li>{$lang.track_no}：
    					<input type="text" name="track_no" id='track_no' class="spc_input">
				</li>
				{/if}
				-->
                <li class="w320">{$lang.sale_order_state}：
                    {select data=C('SALE_ORDER_STATE') initvalue=C('SALE_ORDER_STATE_PENDING') name="sale_order_state" id='sale_order_state' combobox='' empty=true allow=C('SALE_CAN_ADD_STATE')}__*__
                </li> 
                <li>{$lang.insure}：
					{radio data=C('IS_INSURE') name="is_insure" initvalue="2"}
				</li>
			</ul>
		</div>
		</td>
	</tr>   
	<tr><th>{$lang.sale_order_info}<span id="client_fund_show"></span></th></tr>   
	<tr><td>{include file="SaleOrder/detail.tpl"}</td></tr>	
	<tr><th>{$lang.client_info}<input type="hidden" id="city_name_flag" value="1"></th></tr>   
	<tr><td>
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						
						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left"><input type="text" name="addition[1][consignee]" id='consignee' class="spc_input">__*__</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left"><input type="text" name="addition[1][transmit_name]" id='transmit_name' class="spc_input"></td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
								<input type="text" id="country_name" name="addition[1][country_name]" class="spc_input">
								<input type="hidden" name="addition[1][country_id]" id="country_id" class="spc_input">
								<input id="full_country_name" url="{'AutoComplete/country'|U}" jqac >__*__
							</td>
						</tr>
						<tr>
							<td width="25%">{$lang.belongs_city}：</td>
							<td class="t_left">
								<input id="city_name" type="text" name="addition[1][city_name]" class="spc_input">__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left"><input type="text" name="addition[1][email]" id='email' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left"><input type="text" name="addition[1][tax_no]" id='tax_no' class="spc_input"></td>
						</tr>
					</tbody>
				</table>
				</td>
				<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left"><input type="text" name="addition[1][address]" id="address" class="spc_input" >__*__</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left"><input type="text" name="addition[1][address2]" id="address2" class="spc_input" ></td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left"><input type="text" name="addition[1][company_name]" id='company_name' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left"><input type="text" name="addition[1][post_code]" id='post_code' class="spc_input">__*__</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left"><input type="text" name="addition[1][mobile]" id='mobile' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left"><input type="text" name="addition[1][fax]" id='fax' class="spc_input"></td>
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
							<td class="t_left"><textarea id="comments" class="textarea_height80" name="comments"></textarea></td>
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
{staff}
</div>
</form> 