{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
	<tr>
      		<td class="width15">{$lang.id}：</td>
      		<td class="t_left">{$rs.id}</td>
    	</tr>
    	<tr>
      		<td class="width15">{$lang.email}：</td>
      		<td class="t_left">{$rs.email}</td>
    	</tr>
    	<tr>
      		<td >{$lang.factory_name}：</td>
      		<td class="t_left">{$rs.comp_name}</td>
    	</tr>
    	<tr>
    		<td>{$lang.nick_name}：</td>
    		<td class="t_left">
    			{$rs.nick_name}
    		</td>
    	</tr>
	<tr>
		<td>{$lang.is_enable}：</td>
		<td class="t_left">
			{if $rs.to_hide==1}
			{$lang.yes}
			{/if}
			{if $rs.to_hide==2}
			{$lang.no}
			{/if}
		</td>
	</tr>
    	<tr>
      		<td >{$lang.contact}：</td>
      		<td class="t_left">{$rs.contact}</td>
    	</tr>
    	<tr>
      		<td >{$lang.phone}：</td>
      		<td class="t_left">{$rs.mobile}</td>
    	</tr>
        <tr>
      		<td>{$lang.warn_email}：</td>
      		<td class="t_left">{$rs.warn_email}</td>
    	</tr>
    	<tr>
			<td>{$lang.basic_name_ch}：</td>
			<td class="t_left">
				{$rs.basic_name_ch}
			</td>
		</tr>
		<tr>
			<td>{$lang.basic_name_en}：</td>
			<td class="t_left">
				{$rs.basic_name_en}
			</td>
		</tr>
    	<tr>
      		<td>{$lang.web}：</td>
      		<td class="t_left">{$rs.company_factory.web}</td>
    	</tr>
        <tr>
			<td>{$lang.warehouse_connection_qq}：</td>
			<td class="t_left">
                {$rs.warehouse_connection_qq}
			</td>
		</tr>

		{foreach from=$client_currency item='currency_no'}
		<tr>
		<td>{$lang.warning_balance}({$currency_no|strtoupper})：</td>
		<td class="t_left">
		{$rs["warning_balance_`$currency_no`"]}
		</td>
		</tr>
		{/foreach}
		 	
		<tr>
		<td>{$lang.brt_account_no}：</td>
			<td class="t_left">
				{$rs.brt_account_no}
			</td>
		</tr>
        <tr>
			<td>{$lang.is_custom_barcode}：</td>
			<td class="t_left">
                {$rs.company_factory.dd_is_custom_barcode}
			</td>
		</tr>
{*        {if $rs.company_factory.is_custom_barcode==1}
            <tr>
                <td>{$lang.set_custom_barcode_rule}：</td>
                <td class="t_left">
                    {$rs.company_factory.custom_barcode_en}
                    +{$rs.company_factory.custom_barcode_num}
                </td>
            </tr>
        {/if}*}
    	<tr>
      		<td>{$lang.order_combin}：</td>
			<td class="t_left">{$rs.dd_merger}</td>
    	</tr>
        <tr>
            <td colspan=2 style="padding:0 600px 0 210px">{include file="Factory/detail.tpl"}</td>
        </tr>
{*	{foreach $rs.detail as $val}
		<tr>
      		<td>{$val.w_name}{$lang.express_discount}：</td>
			<td class="t_left">{$val.express_discount}</td>
    	</tr>
	{/foreach}*}
		<tr>
      		<td>{$lang.package_discount}：</td>
			<td class="t_left">{$rs.package_discount}</td>
    	</tr>
        <tr>
            <td>{$lang.process_discount_type}：</td>
			<td class="t_left">{$rs.dd_process_discount_type}</td>
        </tr>
		<tr>
      		<td>{$lang.freight_strategy}：</td>
      		<td class="t_left">
				{$rs.dd_freight_strategy}
			</td>
		</tr>
    	<tr>
      		<td >{$lang.tax_no}：</td>
      		<td class="t_left">
				{$rs.tax_no}
      		</td>
    	</tr>
        <tr>
            <td >
                {$lang.is_warehouse_fee}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dd_is_warehouse_fee}
            </td>
    	</tr>
        {if $rs.company_factory.is_warehouse_fee > 0}
        <tr>
      		<td >
                {$lang.warehouse_fee_start_date}：
            </td>
            <td class="t_left">
                {$rs.company_factory.warehouse_fee_start_date}
            </td>
    	</tr>
        {/if}
        <tr>
            <td>
                {$lang.warehouse_fee}{$lang.code}：
            </td>
            <td class="t_left">
                {$rs.company_factory.warehouse_fee_no}
                <img pid="{$rs.company_factory.warehouse_fee_id}" id="warehouse_fee_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'WarehouseFee')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
            </td>
        </tr>
        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dml_warehouse_percentage}%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.is_return_process_fee}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dd_is_return_process_fee}
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dml_return_process_percentage}%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.is_domestic_freight}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dd_is_domestic_freight}
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.percentage_increase}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dml_domestic_freight_percentage}%
            </td>
    	</tr>
        <tr>
      		<td >
                {$lang.arrears_limit_the_use}：
            </td>
            <td class="t_left">
                {$rs.company_factory.dd_arrears_limit}
            </td>
    	</tr>
{*        <tr>
            <td colspan=2 style="padding:0 600px 0 210px">{include file="Factory/warehouseFeeDetail.tpl"}</td>
        </tr>	*}
        <tr>
            <th colspan="2">{$lang.api_interface}</th>
        </tr>
        <tr>
            <td>{$lang.authorization_code}：</td>
            <td class="t_left">{$rs.auth_token}</td>
        </tr>
        <tr>
            <td>{$lang.validity}：</td>
            <td class="t_left">{$rs.dd_auth_status}</td>
        </tr>
    	<tr>
    		<th colspan="2">{$lang.account_info}</th>
    	</tr>
		 <tr style="display:none;">
		  <td>{$lang.use_usbkey}：</td>
		  <td class="t_left">{$rs.dd_use_usbkey}</td>
		</tr>
		 <tr id="td_usekeylicens" {if $rs.use_usbkey==0}style="display:none;"{/if}>
		  <td>{$lang.use_usbkey_licens}：</td>
		  <td class="t_left">{$rs.usbkey}</td>
		</tr>
		<tr>
		  <td>{$lang.user_ip}：</td>
		  <td class="t_left">{$rs.user_ip}</td>
		</tr>
		<tr>
		  <td>{$lang.registration_time}：</td>
		  <td class="t_left">{$rs.fmd_create_time}</td>
		</tr>
		<tr>
		  <td>{$lang.create_ip}：</td>
		  <td class="t_left">{$rs.create_ip}</td>
		</tr>
		<tr>
		  <td valign="top">{$lang.comments}：</td>
		  <td class="t_left">{$rs.edit_user_comments}</td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
    	<tr>
      		<td >{$lang.belongs_country}：</td>
      		<td class="t_left">{$rs.country_name} {$rs.abbr_district_name}</td>
    	</tr>
    	<tr>
      		<td >{$lang.belongs_city}：</td>
      		<td class="t_left">{$rs.city_name}</td>
    	</tr>
      	<tr>
      		<td >{$lang.street1}：</td>
      		<td class="t_left">{$rs.edit_address}</td>
    	</tr>
      	<tr>
      		<td >{$lang.street2}：</td>
      		<td class="t_left">{$rs.edit_address2}</td>
    	</tr>
    	<tr>
      		<td >{$lang.post_code}：</td>
      		<td class="t_left">{$rs.post_code}</td>
    	</tr>
    	<tr>
      		<td >{$lang.fax_no}：</td>
      		<td class="t_left">{$rs.fax}</td>
    	</tr>
    	<tr>
      		<td>{$lang.vat_number}：</td>
			<td class="t_left">{$rs.company_factory.vat_number}</td>
    	</tr>
    	<tr>
      		<td>{$lang.reg_number}：</td>
      		<td class="t_left">{$rs.company_factory.reg_number}</td>
    	</tr>
    	<tr>
      		<td>{$lang.house_bank}：</td>
      		<td class="t_left">{$rs.company_factory.house_bank}</td>
    	</tr>
    	<tr>
      		<td>{$lang.account_holder}：</td>
      		<td class="t_left">{$rs.company_factory.account_holder}</td>
    	</tr>
    	<tr>
      		<td>{$lang.bank_code}：</td>
      		<td class="t_left">{$rs.company_factory.bank_code}</td>
    	</tr>
    	<tr>
      		<td>{$lang.iban_account}：</td>
      		<td class="t_left">{$rs.company_factory.iban_account}</td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left"><p class="line_24">{$rs.edit_comments}</p></td>
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
