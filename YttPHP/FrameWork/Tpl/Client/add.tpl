<form action="{'Client/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" value="1">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="2">{$lang.basic_info}</th>
		</tr>
{*		<tr>
      		<td class="width10">{$lang.code}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$max_no}"  {$is_auto_no}>__*__</td>
    	</tr>*}
        <tr>
      		<td>{$lang.clientname}：</td>
      		<td class="t_left"><input type="text" name="comp_name" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.consignee}：</td>
      		<td class="t_left"><input type="text" name="consignee" class="spc_input" >__*__</td>
    	</tr>
	<!--tr>
		<td>{$lang.transmit_name}：</td>
		<td class="t_left"><input type="text" name="transmit_name" class="spc_input"></td>
	</tr-->
    	<tr>
    		<td>{$lang.tax_no}：</td>
    		<td class="t_left"><input type="text" name="tax_no" class="spc_input" ></td>
    	</tr>
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<tr>
		  <td>{$lang.belongs_seller}：</td>
		  <td class="t_left">
		  <input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
		  <input id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
		  </td>
		</tr>    
		{else}
			<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
		{/if}	
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
	<tr>
    		<td>{$lang.belongs_country}：</td>
    		<td class="t_left">
			<input type="text" name="country_name" class="spc_input">
			<input type="hidden" name="country_id" id="country_id" class="spc_input">
			<input id="country_name" url="{'AutoComplete/country'|U}" jqac >__*__
      		</td>
    	</tr>
    	<tr>
    		<td>{$lang.belongs_city}：</td>
    		<td class="t_left">
    			<input type="text" name="city_name" class="spc_input">__*__
    		</td>
    	</tr>
    	<tr>
    		<td>{$lang.street1}：</td>
    		<td class="t_left"><input type="text" name="address" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
    		<td>{$lang.street2}：</td>
    		<td class="t_left"><input type="text" name="address2" class="spc_input" ></td>
    	</tr>
	<tr>
		<td>{$lang.street3}：</td>
		<td class="t_left"><input type="text" name="company_name" class="spc_input"></td>
	</tr>
    	<tr>
    		<td>{$lang.post_code}：</td>
    		<td class="t_left"><input type="text" name="post_code" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
    		<td>{$lang.phone}：</td>
    		<td class="t_left"><input type="text" name="mobile" class="spc_input" >
    	</tr>
    	<tr>
    		<td>{$lang.fax_no}：</td>
    		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>
    	<tr>
    		<td>{$lang.email}：</td>
    		<td class="t_left"><input type="text" name="email" class="spc_input" ></td>
    	</tr>
    </tbody>
</table>
</form>
</div>
