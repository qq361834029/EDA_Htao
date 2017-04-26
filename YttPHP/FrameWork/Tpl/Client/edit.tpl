<form action="{'Client/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
     	<tr>
      		<td class="width10">{$lang.code}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$rs.comp_no}" {$is_auto_no}>__*__</td>
    	</tr>
	<tr>
      		<td>{$lang.clientname}：</td>
      		<td class="t_left"><input type="text" name="comp_name" value="{$rs.comp_name}" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.consignee}：</td>
      		<td class="t_left"><input type="text" name="consignee" value="{$rs.consignee}" class="spc_input" >__*__</td>
    	</tr>
	<!--tr>
		<td>{$lang.transmit_name}：</td>
		<td class="t_left"><input type="text" name="transmit_name" value="{$rs.transmit_name}" class="spc_input"></td>
	</tr-->
    	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" value="{$rs.tax_no}" class="spc_input" ></td>
    	</tr>
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<tr>
		  <td>{$lang.belongs_seller}：</td>
		  <td class="t_left"> 
		  <input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}"> 
		  {if $rs.factory_readonly}
		  {$rs.factory_name}
		  {else}
		  <input id="factory_name" name="temp[factory_name]" value="{$rs.factory_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
		  {/if}
		  </td>
		</tr>
		{else}
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}"> 
		{/if}
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
	<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">
			<input type="text" name="country_name" class="spc_input" value="{$rs.country_name}">
			<input type="hidden" name="country_id" id="country_id" class="spc_input" value="{$rs.country_id}">
			<input id="country_name" value="{$rs.full_country_name}" url="{'AutoComplete/country'|U}" jqac >__*__
		</td>
    	</tr>
    	<tr>
      		<td>{$lang.belongs_city}：</td>
      		<td class="t_left">
			<input type="text" name="city_name" value="{$rs.city_name}" class="spc_input">__*__
      		</td>
    	</tr> 
    	<tr>
    		<td>{$lang.street1}：</td>
    		<td class="t_left"><input type="text" name="address" class="spc_input" value="{$rs.address}">__*__</td>
    	</tr>
    	<tr>
    		<td>{$lang.street2}：</td>
    		<td class="t_left"><input type="text" name="address2" class="spc_input" value="{$rs.address2}"></td>
    	</tr>
	<tr>
		<td>{$lang.street3}：</td>
		<td class="t_left"><input type="text" name="company_name" value="{$rs.company_name}" class="spc_input"></td>
	</tr>
	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="mobile" value="{$rs.mobile}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.post_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" value="{$rs.post_code}" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" value="{$rs.fax}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input" ></td>
    	</tr>
	</tbody>
</table>
</form>

