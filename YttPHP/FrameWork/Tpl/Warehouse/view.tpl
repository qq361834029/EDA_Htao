{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
		<tr>
			<td class="width10">{$lang.warehouse_no}：</td>
			<td class="t_left">{$rs.w_no}</td>
		</tr>
		<tr>
			<td>{$lang.warehouse_name}：</td>
			<td class="t_left">{$rs.w_name}</td>
		</tr>
		{company
			type="tr" title=$lang.basic_name id="basic_name" name="basic_name" value=$rs.basic_name view=true
			hidden=["id"=>"basic_id","name"=>"basic_id","value"=>$rs.basic_id]
		}
		<tr>
			<td>{$lang.is_use}：</td>
			<td class="t_left">{$rs.dd_is_use}</td>
		</tr>
        <tr>
			<td>{$lang.is_return_sold}：</td>
			<td class="t_left">{$rs.dd_is_return_sold}</td>
		</tr>
        {if $rs.is_return_sold == C('NO_RETURN_SOLD')}
            <tr>
                <td>{$lang.relation_warehouse}：</td>
                <td class="t_left">{$rs.relation_warehouse_name}</td>
            </tr>
        {/if}
        <tr>
			<td>{$lang.currency_name}：</td>
			<td class="t_left">{$rs.currency_no}</td>
        </tr>
		<tr>
			<td>{$lang.warehouse_address}：</td>
			<td class="t_left">{$rs.edit_w_address}</td>
        </tr>
        <tr>
            <td>{$lang.belongs_country}：</td>
            <td class="t_left">{$rs.abbr_district_name}</td>
        </tr>
        <tr>
            <td>{$lang.belongs_city}：</td>
            <td class="t_left">{$rs.city_name}</td>
        </tr>
        <tr>
        	<td>{$lang.basic_name}：</td>
        	<td class="t_left">{$rs.w_basic_name}</td>
        </tr>
        <tr>
        	<td>{$lang.street_name}：</td>
        	<td class="t_left">{$rs.street_name}</td>
        </tr>
        <tr>
        	<td>{$lang.house_number}：</td>
        	<td class="t_left">{$rs.house_number}</td>
        </tr>
        <tr>
        	<td>{$lang.postcode}：</td>
        	<td class="t_left">{$rs.post_code}</td>
        </tr>
        <tr>
			<td>{$lang.warehouse_spec}：</td>
			<td class="t_left">{$rs.size}</td>
		</tr>
		<tr>
			<td>{$lang.warehouse_area}：</td>
			<td class="t_left">{$rs.area}M²</td>
		</tr>
		<tr>
			<td>{$lang.is_default}：</td>
			<td class="t_left">{$rs.dd_is_default}</td>
		</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>
     	<tr>
      		<td>{$lang.landlord}：</td>
      		<td class="t_left">{$rs.landlord}</td>
    	</tr>
     	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left">{$rs.contact}</td>
    	</tr>
     	<tr>
      		<td>{$lang.address}：</td>
      		<td class="t_left">{$rs.edit_address}</td>
    	</tr>
     	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left">{$rs.phone}</td>
    	</tr>
     	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left">{$rs.fax}</td>
    	</tr>
     	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left">{$rs.email}</td>
    	</tr>
     	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left">{$rs.tax_no}</td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_info}：</td>
      		<td class="t_left">{$rs.bank_info}</td>
    	</tr>
     	<tr>
      		<td>{$lang.bank_no}：</td>
      		<td class="t_left">{$rs.bank_no}</td>
    	</tr>
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left">{$rs.edit_comments}</td>
		</tr>
	</tbody>
</table>
</div>

