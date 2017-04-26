<form action="{'District/insert'|U}" validity="productClassDistrict" id="Basic_addCify" method="POST" onsubmit="setFormName('Basic_addCify');return false"">
<div class="table_autoshow" style="border-style:none!important;">
<table cellpadding="0" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<th colspan="2" class="t_left">{$lang.add_city}：</th>
		</tr>
		<tr>
			<td class="width20">{$lang.country_name}：</td>
			<td class="t_left">
				<input type="hidden" name="parent_id" id="parent_id" class="spc_input" value="{$parent_id}"/>
				<input type="text" name="country_name" url="{'AutoComplete/country'|U}" jqac value="{$country_name}" itemto="dialog-quickly_add" />__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.city}：</td>
			<td class="t_left">
				<input type="text" name="district_name" id="district_name_city" class="spc_input" >__*__
			</td>
		</tr>
	</tbody>
</table>
</div>
</form>