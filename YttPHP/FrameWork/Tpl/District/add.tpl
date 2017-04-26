{wz}
<input type="hidden" id="form_name" value="">
<form action="{'District/insert'|U}" validity="productClassDistrict" id="Basic_addCountry" method="POST" onsubmit="setFormName('Basic_addCountry');return false"">
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="2" class="t_left">{$lang.add_country}：</th>
		</tr>
		<tr>
			<td class="width10">{$lang.country_name}：</td>
			<td class="t_left">
				<input type="text" name="district_name" id="district_name"  class="spc_input" >__*__
				
			</td>
		</tr>
		<tr>
			<td>{$lang.country_no}：</td>
			<td class="t_left">
				<input type="text" name="abbr_district_name" class="spc_input">
				<input id="save_operate_buttom" class="button_new " type="submit" value="{$lang.submit}" >
			</td>
		</tr> 
	</tbody>
</table>
</div>
</form>
<br>