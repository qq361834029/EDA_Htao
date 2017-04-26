<form action="{'Factory/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" value="1">
<input type="hidden" name="role_id" id="role_id" value="{C('SELLER_ROLE_ID')}" />
<table cellspacing="0" cellpadding="0" class="add_table" align="center">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left">
      			<input type="text" name="comp_name" class="spc_input" >__*__
      		</td>
    	</tr>
    	<tr>
    		<td>{$lang.nick_name}：</td>
    		<td class="t_left">
    			<input type="text" name="nick_name" id="nick_name" class="spc_input">__*__
    		</td>
    	</tr>
	<tr>
		<td>{$lang.is_enable}：</td>
		<td class="t_left">
			<select id="to_hide" name="to_hide" combobox>
				<option value="1">{$lang.yes}</option>
				<option value="2">{$lang.no}</option>
			</select>__*__
		</td>
	</tr>
    	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left">
      			<input type="text" name="contact" class="spc_input" >__*__
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="mobile" class="spc_input" >__*__</td>
    	</tr>
        <tr>
      		<td>{$lang.warn_email}：</td>
      		<td class="t_left"><input type="text" name="warn_email" class="spc_input" ></td>
    	</tr>
    	<tr>
			<td>{$lang.basic_name_ch}：</td>
			<td class="t_left">
				<input type="text" name="basic_name_ch" id="basic_name_ch" class="spc_input">
			</td>
		</tr>
		<tr>
			<td>{$lang.basic_name_en}：</td>
			<td class="t_left">
				<input type="text" name="basic_name_en" id="basic_name_en" class="spc_input">
			</td>
		</tr>
    	<tr>
      		<td>{$lang.web}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][web]" class="spc_input" ></td>
    	</tr>
		<tr>
			<td>{$lang.warehouse_connection_qq}：</td>
			<td class="t_left">
				<input type="text" name="warehouse_connection_qq" class="spc_input">
			</td>
		</tr>

		{foreach from=$client_currency item='currency_no'}
		<tr>
		<td>{$lang.warning_balance}({$currency_no|strtoupper})：</td>
		<td class="t_left">
		<input type="text" name="warning_balance_{$currency_no}"   class="spc_input" >
		</td>
		</tr>
		{/foreach}		 	
        <tr>
			<td>{$lang.brt_account_no}：</td>
			<td class="t_left">
				<input type="text" name="brt_account_no" class="spc_input">
			</td>
		</tr>
        <tr>
			<td class="red">{$lang.is_custom_barcode}：</td>
			<td class="t_left">
                {select onchange="setCustomBarcode(this);" data=C('IS_CUSTOM_BARCODE') name="company_factory[1][is_custom_barcode]" value="2" combobox=1 no_default=true}
			</td>
		</tr>

{*		<tr id="set_custom_barcode" {if $rs.company_factory.is_custom_barcode!=1}style="display: none"{/if}>
			<td>{$lang.set_custom_barcode_rule}：</td>
			<td class="t_left">
                <input  class="spc_input" name="company_factory[1][custom_barcode_en]" type="text" value="" >
                +
                <input  class="spc_input" name="company_factory[1][custom_barcode_num]" type="text" value="">
                <br>
                <span>({$lang.prefix_code_rule})+({$lang.digital_length_limit})</span>
			</td>
		</tr>*}
    	<tr>
      		<td>{$lang.order_combin}：</td>
		<td class="t_left">{radio data=C('YES_NO') name="merger" value=0}</td>
    	</tr>
	<tr>
		<td colspan=2 style="padding:0 600px 0 210px">{include file="Factory/detail.tpl"}</td>
	</tr>
	<tr>
      		<td>{$lang.package_discount}：</td>
			<td class="t_left"><input type="text" name="package_discount" class="spc_input" ></td>
    	</tr>
        <tr>
            <td>{$lang.process_discount_type}：</td>
			<td class="t_left">{select data=C('PROCESS_DISCOUNT_TYPE') name="process_discount_type" value=1 empty=true combobox=''}</td>
        </tr>
		<tr>
      		<td>{$lang.freight_strategy}：</td>
      		<td class="t_left">
				{select data=C('CFG_FREIGHT_STRATEGY') name="freight_strategy" combobox=1 no_default=true}
			</td>
		</tr>
    	<tr>
      		<td >{$lang.tax_no}：</td>
      		<td class="t_left">
      			<input type="text" name="tax_no" value="" class="spc_input" >
      		</td>
    	</tr>
        <tr>
      		<td >
                {$lang.is_warehouse_fee}：
            </td>
            <td class="t_left">
                {radio data=C('YES_NO') name="company_factory[1][is_warehouse_fee]" onclick="warehouseFeeStartDate(this)" value=0}
            </td>
    	</tr>
        <tr style="display: none;" id='warehouse_fee_start_date'>
      		<td >
                {$lang.warehouse_fee_start_date}：
            </td>
            <td class="t_left">
				{assign var='min_date' value=C('WAREHOUSE_ACCOUNT_MIN_DATE')}
                {paidDate name="company_factory[1][warehouse_fee_start_date]" value="`$this_day`" minDate="`$min_date`"}
            </td>
    	</tr>

        <tr>
            <td>
                {$lang.warehouse_fee}{$lang.code}：
            </td>
            <td class="t_left">
                <input type="hidden" name="company_factory[1][warehouse_fee_id]" onchange="getWarehouseFeeInfo();" id="warehouse_fee_id" class="spc_input">
                <input type="text" name="temp[warehouse_fee_code]" url="{'AutoComplete/warehouseFeeCode'|U}" jqac >
                <img pid="" id="warehouse_fee_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'WarehouseFee')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
            </td>
        </tr>

        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                <input type="text" name="company_factory[1][warehouse_percentage]" value="" class="spc_input" >%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.is_return_process_fee}：
            </td>
            <td class="t_left">
                {radio data=C('YES_NO') name="company_factory[1][is_return_process_fee]" value=0}
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                <input type="text" name="company_factory[1][return_process_percentage]" value="" class="spc_input" >%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.is_domestic_freight}：
            </td>
            <td class="t_left">
                {radio data=C('YES_NO') name="company_factory[1][is_domestic_freight]" value=0}
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                <input type="text" name="company_factory[1][domestic_freight_percentage]" value="" class="spc_input" >%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.arrears_limit_the_use}：
            </td>
            <td class="t_left">
                {radio data=C('ARREARS_LIMIT') name="company_factory[1][arrears_limit]" value=1}
            </td>
    	</tr>
{*        <tr>
            <td colspan=2 style="padding:0 600px 0 210px">{include file="Factory/warehouseFeeDetail.tpl"}</td>
        </tr>	*}
    	<tr>
    		<th colspan="2">{$lang.account_info}</th>
    	</tr>
		<input name="user_type" type="hidden" value="0" />
		 <tr style="display:none;">
		  <td>{$lang.use_usbkey}：</td>
		  <td class="t_left">
			<select name="use_usbkey" onchange="javascript:if(this.value==1){ $dom.find('#td_usekeylicens').show()}else{ $dom.find('#td_usekeylicens').hide();$dom.find('#usbkey').val('')}" combobox>
			<option value="0">{$lang.no}</option>
			<option value="1">{$lang.yes}</option>
			</select>__*__
		  </td>
		</tr>
		 <tr id="td_usekeylicens" style="display:none;">
		  <td>{$lang.use_usbkey_licens}：</td>
		  <td class="t_left">
			<input type="hidden" name="usbkey" id="usbkey" value="">
			<input type="text" url="{'/AutoComplete/epass'|U}" where="{"id not in (select usbkey from user where to_hide=1)"|urlencode}" jqac>
			__*__
		  </td>
		</tr>
		<tr>
		  <td>{$lang.user_password}：</td>
		  <td class="t_left">
			<input type="password" name="user_password" id="user_password" value="" class="spc_input" />__*__
		  </td>
		</tr>
		<tr>
		  <td>{$lang.user_confirm_password}：</td>
		  <td class="t_left">
				<input type="password" name="user_password_confirm" id="user_password_confirm" value="" class="spc_input" />__*__
		 </td>
		</tr>
		<tr>
		  <td>{$lang.user_ip}：</td>
		  <td class="t_left">
			<input type="text" name="user_ip" id="user_ip" value="" class="spc_input" /> ({$lang.user_ip_separator})
		  </td>
		</tr>
		<tr>
		  <td valign="top">{$lang.comments}：</td>
		  <td class="t_left">
			<textarea name="user_comments"></textarea>
		  </td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
    	<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">
			<input type="text" id="country_name" name="country_name" class="spc_input">
			<input type="hidden" name="country_id" id="country_id" class="spc_input">
			<input type="text" name="temp[full_country_name]" url="{'AutoComplete/country'|U}" jqac >
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.belongs_city}：</td>
      		<td class="t_left">
			<input id="city_name" type="text" name="city_name" class="spc_input">
		</td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.street1}：</td>
      		<td class="t_left"><input type="text" name="address" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.street2}：</td>
      		<td class="t_left"><input type="text" name="address2" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.post_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.vat_number}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][vat_number]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.reg_number}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][reg_number]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.house_bank}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][house_bank]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.account_holder}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][account_holder]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.bank_code}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][bank_code]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.iban_account}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][iban_account]" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left"><textarea name="comments"></textarea></td>
    	</tr>
		<tr>
			<td>{$lang.upload_logo}：</td>
			<td class="t_left">
				{upload tocken=$file_tocken sid=$sid type=30}
			</td>
		</tr>
	</tbody>
</table>
</div>
</form>