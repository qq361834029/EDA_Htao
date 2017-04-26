<form action="{'Factory/updateSetting'|U}" method="POST" onsubmit="return false">
{wz action="save,reset"}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="company_factory[1][id]" value="{$rs.company_factory.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<input type="hidden" name="role_id" id="role_id" value="{C('SELLER_ROLE_ID')}" />
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
	<tr>
      		<td >{$lang.id}：</td>
      		<td class="t_left">{$rs.id}</td>
    	</tr>	
	<tr>
      		<td >{$lang.email}：</td>
      		<td class="t_left"><input type="hidden" name="email" value="{$rs.email}" />{$rs.email}</td>
    	</tr>			
    	<tr>
      		<td >{$lang.real_name}：</td>
      		<td class="t_left">
      			<input type="text" name="comp_name" value="{$rs.comp_name}" class="spc_input" >__*__
      		</td>
    	</tr>
    	<tr>
    		<td>{$lang.nick_name}：</td>
    		<td class="t_left">
    			<input type="text" name="nick_name" id="nick_name" value="{$rs.nick_name}" class="spc_input">__*__
    		</td>
    	</tr>
    	<tr>
      		<td >{$lang.contact}：</td>
      		<td class="t_left">
      			<input type="text" name="contact" value="{$rs.contact}" class="spc_input" >__*__
      		</td>
    	</tr>			
    	<tr>
      		<td >{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="mobile" value="{$rs.mobile}" class="spc_input" >__*__</td>
    	</tr>		
        <tr>
            <td >{$lang.warn_email}：</td>
      		<td class="t_left"><input type="text" name="warn_email" value="{$rs.warn_email}" class="spc_input" ></td>
        </tr>
    	<tr>
			<td>{$lang.basic_name_ch}：</td>
			<td class="t_left">
				<input type="text" name="basic_name_ch" id="basic_name_ch" class="spc_input" value="{$rs.basic_name_ch}">
			</td>
		</tr>
		<tr>
			<td>{$lang.basic_name_en}：</td>
			<td class="t_left">
				<input type="text" name="basic_name_en" id="basic_name_en" class="spc_input" value="{$rs.basic_name_en}">
			</td>
		</tr>
    	<tr>
      		<td>{$lang.web}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][web]" value="{$rs.company_factory.web}" class="spc_input" ></td>
    	</tr>
		{foreach from=$client_currency item='currency_no'}
		<tr>
		<td>{$lang.warning_balance}({$currency_no|strtoupper})：</td>
		<td class="t_left">
		<input type="text" name="warning_balance_{$currency_no}"   class="spc_input" value="{$rs["warning_balance_`$currency_no`"]}">
		</td>
		</tr>
		{/foreach}
		  <tr>
			<td>{$lang.brt_account_no}：</td>
			<td class="t_left">
				<input type="text" name="brt_account_no"  value="{$rs.brt_account_no}" class="spc_input">
			</td>
		</tr>
        <tr>
			<td class="red">{$lang.is_custom_barcode}：</td>
			<td class="t_left">
                {select onchange="setCustomBarcode(this);" data=C('IS_CUSTOM_BARCODE') name="company_factory[1][is_custom_barcode]" value={($rs.company_factory.is_custom_barcode==1)|a2bc:1:2} combobox=1 no_default=true}  
			</td>
		</tr>
{*		<tr id="set_custom_barcode" {if $rs.company_factory.is_custom_barcode!=1}style="display: none"{/if}>
			<td>{$lang.set_custom_barcode_rule}：</td>
			<td class="t_left">
                <input  class="spc_input" name="company_factory[1][custom_barcode_en]" type="text" value="{$rs.company_factory.custom_barcode_en}" >
                +
                <input  class="spc_input" name="company_factory[1][custom_barcode_num]" type="text" value="{$rs.company_factory.custom_barcode_num}">
                <br>
                <span>({$lang.prefix_code_rule})+({$lang.digital_length_limit})</span>
			</td>
		</tr>*}
    	<tr>
      		<td>{$lang.order_combin}：</td>
			<td class="t_left">{radio data=C('YES_NO') name="merger" value=$rs.merger}</td>
    	</tr>
		<tr>
      		<td>{$lang.express_discount}：</td>
			<td class="t_left">{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}<input type="text" name="express_discount" value="{$rs.edml_express_discount}" class="spc_input" >{else}<input type="hidden" name="express_discount" value="{$rs.express_discount}" />{$rs.dml_express_discount}{/if}</td>
    	</tr>
		<tr>
      		<td>{$lang.package_discount}：</td>
			<td class="t_left">{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}<input type="text" name="package_discount" value="{$rs.edml_package_discount}" class="spc_input" >{else}<input type="hidden" name="package_discount" value="{$rs.package_discount}" />{$rs.dml_package_discount}{/if}</td>
    	</tr>		
		<tr>
      		<td>{$lang.process_discount}：</td>
			<td class="t_left">{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}<input type="text" name="process_discount" value="{$rs.edml_process_discount}" class="spc_input" >{else}<input type="hidden" name="process_discount" value="{$rs.process_discount}" />{$rs.dml_process_discount}{/if}</td>
    	</tr>		
		<tr>
      		<td>{$lang.freight_strategy}：</td>
      		<td class="t_left">
				{select data=C('CFG_FREIGHT_STRATEGY') name="freight_strategy" combobox=1 no_default=true initvalue=$rs.freight_strategy}  
			</td>  
		</tr>	
    	<tr>
      		<td >{$lang.tax_no}：</td>
      		<td class="t_left">
      			<input type="text" name="tax_no" value="{$rs.tax_no}" class="spc_input" >
      		</td>
    	</tr>
		{if $rs.company_factory.is_warehouse_fee > 0}
        <tr>
      		<td >
                {$lang.warehouse_fee}{$lang.code}：
            </td>
            <td class="t_left">
                {$rs.company_factory.warehouse_fee_no}
                <img pid="{$rs.company_factory.warehouse_fee_id}" id="warehouse_fee_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'WarehouseFee')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
            </td>
    	</tr>
        {/if}
    	<tr>
    		<th colspan="2">{$lang.product_barcode}{$lang.info}</th>
    	</tr>
		 <tr>
		  <td>{$lang.optional_items}：</td>
		  <td class="t_left">
			  {checkbox name='product_barcode_config[]' id='product_barcode_config' data=C('CFG_FACTORY_PRODUCT_BARCODE_CONFIG') value=$rs.product_barcode_config}
		  </td>
		</tr>
        <tr>
            <th colspan="2">{$lang.api_interface}</th>
        </tr>
        <tr>            
            <td>{$lang.authorization_code}：</td>
            <td class="t_left">
                <input type="text" class="spc_input disabled" name="auth_token" id="auth_token" value="{$rs.auth_token}" style="width: 200px !important;">
            </td>
        </tr>
        <tr>            
            <td>{$lang.validity}：</td>
            <td class="t_left">{$rs.dd_auth_status}</td>
        </tr>
        {if $rs.auth_token eq ''}
        <tr>
            <td>
            </td>
            <td class="t_left">
                <input type="button" sheet="0" id="get_token" onclick="$.getApiToken({$rs.id})" class="other" value="{$lang.apply_api}" />
            </td>
        </tr>
        {/if}
    	<tr>
    		<th colspan="2">{$lang.account_info}</th>
    	</tr>
		<input name="user_type" type="hidden" value="{$rs.user_type}" />
		<input name="user_id" type="hidden" value="{$rs.user_id}" />
		 <tr style="display:none;">
		  <td>{$lang.use_usbkey}：</td>
		  <td class="t_left">
			<select name="use_usbkey" onchange="javascript:if(this.value==1){ $dom.find('#td_usekeylicens').show()}else{ $dom.find('#td_usekeylicens').hide();$dom.find('#usbkey').val('')}" combobox>
				<option value="0" {if $rs.use_usbkey==0}selected{/if}>{$lang.no}</option>
				<option value="1" {if $rs.use_usbkey==1}selected{/if}>{$lang.yes}</option>
			</select>__*__
		  </td>
		</tr>
		 <tr id="td_usekeylicens" {if $rs.use_usbkey==0}style="display:none;"{/if}>
		  <td>{$lang.use_usbkey_licens}：</td>
		  <td class="t_left">
			<input type="hidden" name="usbkey" id="usbkey" value="{$rs.usbkey}"> 
			<input type="text" url="{'/AutoComplete/epass'|U}" where="{"id not in (select usbkey from user where to_hide=1 and id!={$rs.user_id})"|urlencode}" value="{$rs.epass_serial}" jqac> 
			__*__
		  </td>
		</tr>      
		<tr>
		  <td>{$lang.user_ip}：</td>
		  <td class="t_left">
			<input type="text" name="user_ip" id="user_ip" value="{$rs.user_ip}" class="spc_input" /> ({$lang.user_ip_separator})
		  </td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
    	<tr>
      		<td >{$lang.belongs_country}：</td>
      		<td class="t_left">
			<input type="text" name="country_name" class="spc_input" value="{$rs.country_name}">
			<input type="hidden" name="country_id" id="country_id" class="spc_input" value="{$rs.country_id}">
			<input id="country_name" name="temp[full_country_name]" value="{$rs.full_country_name}" url="{'AutoComplete/country'|U}" jqac >
      		</td>
    	</tr>
    	<tr>
      		<td >{$lang.belongs_city}：</td>
      		<td class="t_left">
      			<input type="text" name="city_name" value="{$rs.city_name}" class="spc_input">
      		</td>
    	</tr>		
     	<tr>
      		<td >{$lang.street1}：</td>
      		<td class="t_left"><input type="text" name="address" value="{$rs.edit_address}" class="spc_input" ></td>
    	</tr>		
     	<tr>
      		<td >{$lang.street2}：</td>
      		<td class="t_left"><input type="text" name="address2" value="{$rs.edit_address2}" class="spc_input" ></td>
    	</tr>			
    	<tr>
      		<td >{$lang.post_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" value="{$rs.post_code}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td >{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" value="{$rs.fax}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.vat_number}：</td>
			<td class="t_left"><input type="text" name="company_factory[1][vat_number]" value="{$rs.company_factory.vat_number}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.reg_number}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][reg_number]" value="{$rs.company_factory.reg_number}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.house_bank}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][house_bank]" value="{$rs.company_factory.house_bank}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.account_holder}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][account_holder]" value="{$rs.company_factory.account_holder}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.bank_code}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][bank_code]" value="{$rs.company_factory.bank_code}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.iban_account}：</td>
      		<td class="t_left"><input type="text" name="company_factory[1][iban_account]" value="{$rs.company_factory.iban_account}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td  valign="top">{$lang.comments}：</td>
      		<td class="t_left"><textarea name="comments">{$rs.edit_comments}</textarea></td>
    	</tr>
		<tr>
			<td>{$lang.upload_logo}：</td>
			<td class="t_left">
				{upload tocken=$file_tocken sid=$sid type=30}
			</td>
		</tr>
		{if $rs.pics}
		<tr>
			<td>{$lang.logo}：</td>
			<td class="t_left">{showFiles from=$rs.pics delete=1}
			</td>
		</tr>
		{/if}
	</tbody>
</table>
</div>
</form>

