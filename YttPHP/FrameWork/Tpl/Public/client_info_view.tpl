{if $rs.addition}
	{assign var='addition' value=$rs.addition}
{else}
	{assign var='addition' value=$rs}
{/if}
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td width="50%">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td width="20%">{$lang.consignee}：</td>
							<td class="t_left" width="80%">{$addition.consignee}</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left">{$addition.transmit_name}</td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">{$addition.country_name} {$addition.abbr_district_name}</td>
						</tr>
						<tr>
							<td width="25%">{$lang.belongs_city}：</td>
							<td class="t_left">{$addition.city_name}</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left">{$addition.email}</td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left">{$addition.tax_no}</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top" width="20%">{$lang.street1}：</td>
							<td class="t_left" width="80%">{$addition.address}</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left">{$addition.address2}</td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left">{$addition.company_name}</td>
						</tr>
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left">{$addition.post_code}</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left">{$addition.mobile}</td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left">{$addition.fax}</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>