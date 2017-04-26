<form action="{'Warehouse/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
		<tr>
			<td class="width10">{$lang.warehouse_no}：</td>
			<td class="t_left"><input type="text" name="w_no" value="{$max_no}" {$is_auto_no}/>__*__</td>
		</tr>
		<tr>
			<td>{$lang.warehouse_name}：</td>
			<td class="t_left">
				<input type="text" name="w_name" id="w_name" class="spc_input" >__*__</td>
		</tr>
		{company
			type="tr" id="basic_name" name="basic_name" title=$lang.basic_name require=true
			hidden=["id"=>"basic_id","name"=>"basic_id"]
			}
		<tr>
			<td>{$lang.is_use}：</td>
			<td class="t_left">
				{radio data=C('IS_USE') value=1 name="is_use"}
			</td>
		</tr>
        <tr>
			<td>{$lang.is_return_sold}：</td>
			<td class="t_left">
				{radio data=C('IS_RETURN_SOLD') value=1 onclick="showRelationWarehouse(this);" name="is_return_sold"}
			</td>
		</tr>
        <tr style="display: none;">
			<td>{$lang.relation_warehouse}：</td>
			<td class="t_left">
                <input type="hidden" name="relation_warehouse_id" id="relation_warehouse_id" class="spc_input">
                <input id="full_country_name" url="{'AutoComplete/saleWarehouse'|U}" jqac >__*__
			</td>
		</tr>
            {currency data=C('CLIENT_CURRENCY') name="currency_id" id="currency_id" value=C('SYS_EURO_ID') type='tr' title=$lang.currency_name require="true" class="valid-required"}
        <tr>
			<td>{$lang.warehouse_address}：</td>
			<td class="t_left"><input type="text" name="w_address" class="spc_input"/></td>
		</tr>
        <tr>
            <td>{$lang.belongs_country}：</td>
            <td class="t_left">
                <input type="hidden" name="country_id" id="country_id" class="spc_input">
                <input id="full_country_name" url="{'AutoComplete/country'|U}" jqac >__*__
            </td>
        </tr>
        <tr>
            <td>{$lang.belongs_city}：</td>
            <td class="t_left">
                <input type="text" name="city_name" class="spc_input"/></td>
            </td>
        </tr>
        <tr>
        	<td>{$lang.basic_name}：</td>
        	<td class="t_left"><input type="text" name="w_basic_name" id="w_basic_name" class="spc_input"></td>
        </tr>
        <tr>
        	<td>{$lang.street_name}：</td>
        	<td class="t_left"><input type="text" name="street_name" id="street_name" class="spc_input"></td>
        </tr>
        <tr>
        	<td>{$lang.house_number}：</td>
        	<td class="t_left"><input type="text" name="house_number" id="house_number" class="spc_input"></td>
        </tr>
        <tr>
        	<td>{$lang.postcode}：</td>
        	<td class="t_left"><input type="text" name="post_code" id="post_code" class="spc_input"></td>
        </tr>
     	<tr>
      		<td>{$lang.warehouse_spec}：</td>
      		<td class="t_left"><input type="text" name="size" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.warehouse_area}：</td>
      		<td class="t_left"><input type="text" name="area" class="spc_input" >M²</td>
    	</tr>
		<tr>
			<td>{$lang.is_default}：</td>
			<td class="t_left">
				{radio data=C('IS_DEFAULT') value=2 name="is_default"}
			</td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
     	<tr>
      		<td>{$lang.landlord}：</td>
      		<td class="t_left"><input type="text" name="landlord" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.address}：</td>
      		<td class="t_left"><input type="text" name="address" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="phone" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_info}：</td>
      		<td class="t_left"><input type="text" name="bank_info" class="spc_input" ></td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_no}：</td>
      		<td class="t_left"><input type="text" name="bank_no" class="spc_input" ></td>
    	</tr>
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60"></textarea></td>
		</tr>
	</tbody>
</table>
</div>
</form>

