{wz}
<input type="hidden" id="form_name" value="">

<form action="{'District/insert'|U}" validity="productClassDistrict" id="Basic_addCify" method="POST" onsubmit="setFormName('Basic_addCify');return false"">
<div class="add_box">
<table cellpadding="0" cellspacing="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="2" class="t_left">{$lang.add_city}：</th>
		</tr>
		<tr>
			<td class="width10">{$lang.country_name}：</td>
			<td class="t_left">
				<input type="hidden" name="parent_id" id="parent_id" class="spc_input" />
				<input type="text" name="country_name" url="{'AutoComplete/country'|U}" jqac />__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.city}：</td>
			<td class="t_left">
				<input type="text" name="district_name" id="district_name_city" class="spc_input" >__*__
				<input id="save_operate_buttom" class="button_new " type="submit" value="{$lang.submit}">
			</td>
		</tr>
	</tbody>
</table>
</div>
</form>