<form action="{'Client/insert'|U}" method="POST" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<th colspan="2">{$lang.basic_info}</th>
		</tr>
		{if 'multi_client'|C==1}
		<tr>
			<td>{$lang.client_type}：</td>
			<td class="t_left">{html_radios options=C('CLIENT_TYPE') name="detail_type" checked=1 id="client_type" }__*__</td>
		</tr>
		{/if}
{*		<tr>
      		<td class="width20">{$lang.client_no}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$max_no}" {$is_auto_no}>__*__
    	</tr>*}
		<input type="hidden" value="0" id="city_name_flag"></td>
    	<tr>
      		<td>{$lang.client_name}：</td>
      		<td class="t_left"><input type="text" name="comp_name" class="spc_input" >__*__</td>
    	</tr>
	
	{if $login_user.role_type!=2}
	<tr>
		<td>{$lang.belongs_seller}：</td>
		<td class="t_left">
			<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
                        {if $smarty.get.factory_id > 0}
                            {$fac_name}
                        {else}
                            <input itemto="dialog-quickly_add" id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
                        {/if}
		</td>
	</tr>
	{else}
		<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
	{/if}
	<tr>
      		<td class="width20">{$lang.consignee}：</td>
    		<td class="t_left"><input type="text" name="consignee" class="spc_input" >__*__</td>
    	</tr>
	<!--tr>
		<td class="width20">{$lang.transmit_name}：</td>
		<td class="t_left"><input type="text" name="transmit_name" class="spc_input"></td>
	</tr-->
    	<tr>
      		<td class="width20">{$lang.tax_no}：</td>
    		<td class="t_left"><input type="text" name="tax_no" class="spc_input" ></td>
    	</tr>
	<tr>
    		<td>{$lang.email}：</td>
    		<td class="t_left"><input type="text" name="email" class="spc_input" ></td>
    	</tr>
	<tr>
    		<td>{$lang.phone}：</td>
    		<td class="t_left"><input type="text" name="mobile" class="spc_input" ></td>
    	</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
	<tr>
    		<td>{$lang.belongs_country}：</td>
    		<td class="t_left">
			<input type="text" id="country_name" name="country_name" class="spc_input">
			<input type="hidden" name="country_id" id="country_id" class="spc_input">
			<input id="full_country_name" url="{'AutoComplete/country'|U}" jqac itemto="dialog-quickly_add" >__*__
		</td>
    	</tr>
    	<tr>
    		<td>{$lang.belongs_city}：</td>
    		<td class="t_left">
			<input type="text" name="city_name" class="spc_input">__*__
    		</td>
    	</tr>
	<tr>
      		<td valign="top">{$lang.street1}：</td>
      		<td class="t_left"><input type="text" name="address" id="address" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.street2}：</td>
      		<td class="t_left"><input type="text" name="address2" id="address2" class="spc_input" ></td>
    	</tr>
	<tr>
		<td class="width20">{$lang.street3}：</td>
		<td class="t_left"><input type="text" name="company_name" class="spc_input"></td>
	</tr>
    	<tr>
    		<td>{$lang.post_code}：</td>
    		<td class="t_left"><input type="text" name="post_code" class="spc_input" >__*__</td>
    	</tr>
	<tr>
    		<td>{$lang.fax_no}：</td>
    		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>
    </tbody>
</table>
</div>
</form>