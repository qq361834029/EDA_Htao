<form action="{'Warehouse/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
		<tr>
			<td class="width10">{$lang.warehouse_no}：</td>
			<td class="t_left"><input type="text" name="w_no" value="{$rs.w_no}" {$is_auto_no}/>__*__</td>
		</tr>
		<tr>
			<td>{$lang.warehouse_name}：</td>
			<td class="t_left">
				<input type="text" name="w_name" id="w_name" value="{$rs.w_name}" class="spc_input" >__*__
			</td>
		</tr>
		{company
			type="tr" title=$lang.basic_name id="basic_name" name="basic_name" value=$rs.basic_name require=true
			hidden=["id"=>"basic_id","name"=>"basic_id","value"=>$rs.basic_id]
		}
		<tr>
			<td>{$lang.is_use}：</td>
			<td class="t_left">
				{radio data=C('IS_USE') value=$rs.is_use name="is_use"}
			</td>
		</tr>
        <tr>
			<td>{$lang.is_return_sold}：</td>
			<td class="t_left">
				{radio data=C('IS_RETURN_SOLD') value=$rs.is_return_sold onclick="showRelationWarehouse(this);"  name="is_return_sold"}
			</td>
		</tr>
        <tr {if $rs.is_return_sold != C('NO_RETURN_SOLD')}style="display: none;"{/if}>
			<td>{$lang.relation_warehouse}：</td>
			<td class="t_left">
                <input type="hidden" name="relation_warehouse_id" id="relation_warehouse_id" value="{$rs.relation_warehouse_id}" class="spc_input">
                <input id="full_country_name" url="{'AutoComplete/saleWarehouse'|U}" where="id<>{$rs.id}" value="{$rs.relation_warehouse_name}" jqac >__*__
			</td>
		</tr>
        {currency data=C('CLIENT_CURRENCY') name="currency_id" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="true" view=$exist_sale_order class="valid-required"}
		<tr>
			<td>{$lang.warehouse_address}：</td>
			<td class="t_left"><input type="text" name="w_address" value="{$rs.w_address}" class="spc_input"/></td>
		</tr>
        <tr>
            <td>{$lang.belongs_country}：</td>
            <td class="t_left">
                <input type="hidden" value="{$rs.country_id}" name="country_id" id="country_id" class="spc_input">
                <input id="full_country_name" url="{'AutoComplete/country'|U}" value="{$rs.full_country_name}" jqac >__*__
            </td>
        </tr>
        <tr>
            <td>{$lang.belongs_city}：</td>
            <td class="t_left">
                <input type="text" name="city_name" value="{$rs.city_name}" class="spc_input"/></td>
            </td>
        </tr>
        <tr>
        	<td>{$lang.basic_name}：</td>
        	<td class="t_left"><input type="text" name="w_basic_name" id="w_basic_name" class="spc_input" value="{$rs.w_basic_name}"></td>
        </tr>
        <tr>
        	<td>{$lang.street_name}：</td>
        	<td class="t_left"><input type="text" name="street_name" id="street_name" class="spc_input" value="{$rs.street_name}"></td>
        </tr>
        <tr>
        	<td>{$lang.house_number}：</td>
        	<td class="t_left"><input type="text" name="house_number" id="house_number" class="spc_input" value="{$rs.house_number}"></td>
        </tr>
        <tr>
        	<td>{$lang.postcode}：</td>
        	<td class="t_left"><input type="text" name="post_code" id="post_code" class="spc_input" value="{$rs.post_code}"></td>
        </tr>
		<tr>
			<td>{$lang.warehouse_spec}：</td>
			<td class="t_left"><input type="text" name="size" value="{$rs.size}" class="spc_input"/></td>
		</tr>
		<tr>
			<td>{$lang.warehouse_area}：</td>
			<td class="t_left"><input type="text" name="area" value="{$rs.area}" class="spc_input"/>M²</td>
		</tr>
		<tr>
			<td>{$lang.is_default}：</td>
			<td class="t_left">
				{radio data=C('IS_DEFAULT') value=$rs.is_default name="is_default"}
			</td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
     	<tr>
      		<td>{$lang.landlord}：</td>
      		<td class="t_left"><input type="text" name="landlord" value="{$rs.landlord}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" value="{$rs.contact}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.address}：</td>
      		<td class="t_left"><input type="text" name="address" value="{$rs.edit_address}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="phone" value="{$rs.phone}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" value="{$rs.fax}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" value="{$rs.tax_no}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_info}：</td>
      		<td class="t_left"><input type="text" name="bank_info" value="{$rs.bank_info}" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_no}：</td>
      		<td class="t_left"><input type="text" name="bank_no" value="{$rs.bank_no}" class="spc_input" ></td>
    	</tr>
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60">{$rs.edit_comments}</textarea></td>
		</tr>
	</tbody>
</table>
</div>
</form>

