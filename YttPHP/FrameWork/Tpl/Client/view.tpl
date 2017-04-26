{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>
    <tr>
      <td class="width10">{$lang.code}：</td>
      <td class="t_left">{$rs.comp_no}</td>
    </tr>
    <tr>
      <td>{$lang.clientname}：</td>
      <td class="t_left">{$rs.comp_name}</td>
    </tr>
    <tr>
      <td>{$lang.consignee}：</td>
      <td class="t_left">{$rs.consignee}</td>
    </tr>
    <!--tr>
	<td>{$lang.transmit_name}：</td>
	<td class="t_left">{$rs.transmit_name}</td>
</tr-->
    <tr>
      <td>{$lang.tax_no}：</td>
      <td class="t_left">{$rs.tax_no}</td>
    </tr>

	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
	<tr>
	  <td>{$lang.belongs_seller}：</td>
	  <td class="t_left"> 
	  {$rs.factory_name}
	  </td>
	</tr>
	{/if}
    <tr>
    	<th colspan="2">{$lang.contact_info}</th>
    </tr>
     <tr>
      <td>{$lang.belongs_country}：</td>
      <td class="t_left">{$rs.country_name} {$rs.abbr_district_name}</td>
    </tr>
    <tr>
      <td>{$lang.belongs_city}：</td>
      <td class="t_left">{$rs.city_name}</td>
    </tr> 
	<tr>
		<td>{$lang.street1}：</td>
		<td class="t_left">{$rs.edit_address}</td>
	</tr>
	<tr>
		<td>{$lang.street2}：</td>
		<td class="t_left">{$rs.edit_address2}</td>
	</tr>
	<tr>
		<td>{$lang.street3}：</td>
		<td class="t_left">{$rs.company_name}</td>
	</tr>
    <tr>
      <td>{$lang.phone}：</td>
      <td class="t_left">{$rs.mobile}</td>
    </tr>
    <tr>
      <td>{$lang.post_code}：</td>
      <td class="t_left">{$rs.post_code}</td>
    </tr>
    <tr>
      <td>{$lang.fax_no}：</td>
      <td class="t_left">{$rs.fax}</td>
    </tr>
    <tr>
      <td>{$lang.email}：</td>
      <td class="t_left">{$rs.email}</td>
    </tr>
    </tbody>
  </table>
</div>