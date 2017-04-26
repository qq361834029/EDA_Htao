{if $not_readonly or ($rs and $rs.is_related_sale_order != C('IS_RELATED_SALE_ORDER'))}
	{assign var='class_disabled' value=''}
	{assign var='attr_readonly' value=''}
{else}
	{assign var='class_disabled' value='disabled'}
	{assign var='attr_readonly' value='readonly'}	
{/if}
{if $rs.addition}
	{assign var='addition' value=$rs.addition}
{else}
	{assign var='addition' value=$rs}
{/if}
<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<input value="{$addition.id}" type="hidden" name="addition[id]">
	<tbody>
		<tr>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left">
								<input type="text" name="addition[consignee]" value="{$addition.consignee}" id='consignee' class="spc_input {$class_disabled}" {$attr_readonly}>__*__
							</td>
						</tr>
						<!--tr>
							<td>{$lang.transmit_name}：</td>
							<td class="t_left">
								<input type="text" name="addition[transmit_name]" value="{$addition.transmit_name}" id='transmit_name' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr-->
						<tr>
							<td>{$lang.belongs_country}：</td>
							<td class="t_left">
								<input type="text" id="country_name" name="addition[country_name]" value="{$addition.country_name}" class="spc_input {$class_disabled}" {$attr_readonly}>
								<input type="hidden" name="addition[country_id]" id="country_id" value="{$addition.country_id}" class="spc_y_idinput {$class_disabled}" {$attr_readonly}>
								<input id="full_country_name" {if $not_readonly or ($rs and $rs.is_related_sale_order != C('IS_RELATED_SALE_ORDER'))}url="{'AutoComplete/country'|U}"  jqac {/if} value="{$addition.full_country_name}" class="spc_input {$class_disabled}" {$attr_readonly} autocomplete="off">__*__
							</td>
						</tr>
						<tr>
							<td width="25%">{$lang.belongs_city}：</td>
							<td class="t_left">
								<input id="city_name" type="text" name="addition[city_name]" value="{$addition.city_name}" class="spc_input {$class_disabled}" {$attr_readonly}>__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left">
								<input type="text" name="addition[email]" value="{$addition.email}" id='email' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left">
								<input type="text" name="addition[tax_no]" value="{$addition.tax_no}" id='tax_no' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left">
								<input type="text" name="addition[address]" value="{$addition.address}" id="address" class="spc_input {$class_disabled}" {$attr_readonly}>__*__
							</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left">
								<input type="text" name="addition[address2]" value="{$addition.address2}" id="address2" class="spc_input {$class_disabled}" {$attr_readonly} >
							</td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left">
								<input type="text" name="addition[company_name]" value="{$addition.company_name}" id='company_name' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr>
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left">
								<input type="text" name="addition[post_code]" value="{$addition.post_code}" id='post_code' class="spc_input {$class_disabled}" {$attr_readonly}>__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left">
								<input type="text" name="addition[mobile]" value="{$addition.mobile}" id='mobile' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr>
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left">
								<input type="text" name="addition[fax]" value="{$addition.fax}" id='fax' class="spc_input {$class_disabled}" {$attr_readonly}>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>