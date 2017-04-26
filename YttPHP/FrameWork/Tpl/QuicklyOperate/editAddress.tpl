<form action="{'SaleOrder/updateAddress'|U}" method="POST" beforeSubmit="checkSaleaState">
    <input type="hidden" name="id" id="id" value="{$rs.id}"/> 
			<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
            <input type="hidden" name="warehouse_id" id="warehouse_id" value="{$rs.warehouse_id}">
            <input type="hidden" name="express_id" id="express_id" value="{$rs.express_id}">
            <input type="hidden" name="express_detail_id" id="express_detail_id" value="{$rs.express_detail_id}">
            <input type="hidden" name="from_type" id="from_type" value="editAddress">
            <input type="hidden" name="addition[1][country_id]" id="addition[1]country_id" value="{$rs.country_id}">
            <input value="{$rs.addition_id}" type="hidden" name="addition[1][id]">
<table cellspacing="0" cellpadding="0" class="table_autoshow" style="width: 356px;">
	<tbody>
                        <tr>
                        <td>{$lang.sale_order_state}：</td>
                        <td class="t_left">
                            <input type="hidden" name="sale_order_state" id="sale_order_state" value="{$rs.sale_order_state}">
                            <input type="text" itemto="dialog-edit_address" name="dd_sale_order_state" id="dd_sale_order_state" value="{$rs.dd_sale_order_state}" url="{'/AutoComplete/saleOrderState'|U}" where="object_id={$rs.id}" jqac/>__*__
                        </td>
                        </tr>
						<tr>
							<td>{$lang.consignee}：</td>
							<td class="t_left"><input value="{$rs.consignee}" type="text" name="addition[1][consignee]" id='consignee' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.belongs_city}：</td>
							<td class="t_left">
								<input type="text" name="addition[1][city_name]" value="{$rs.city_name}" class="spc_input">__*__
							</td>
						</tr>
						<tr>
							<td>{$lang.email}：</td>
							<td class="t_left"><input value="{$rs.email}" type="text" name="addition[1][email]" id='email' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.tax_no}：</td>
							<td class="t_left"><input value="{$rs.tax_no}" type="text" name="addition[1][tax_no]" id='tax_no' class="spc_input"></td>
						</tr>
						<tr>
							<td valign="top">{$lang.street1}：</td>
							<td class="t_left"><input value="{$rs.edit_address}" type="text" name="addition[1][address]" id="address" class="spc_input" >__*__</td>
						</tr>
						<tr>
							<td valign="top">{$lang.street2}：</td>
							<td class="t_left"><input value="{$rs.edit_address2}" type="text" name="addition[1][address2]" id="address2" class="spc_input" ></td>
						</tr>
						<tr>
							<td>{$lang.street3}：</td>
							<td class="t_left"><input value="{$rs.company_name}" type="text" name="addition[1][company_name]" id='company_name' class="spc_input"></td>
						</tr>
						
						<tr>
							<td>{$lang.postcode}：</td>
							<td class="t_left"><input value="{$rs.post_code}" type="text" name="addition[1][post_code]" id='post_code' class="spc_input">__*__</td>
						</tr>
						<tr>
							<td>{$lang.client_tel}：</td>
							<td class="t_left"><input value="{$rs.mobile}" type="text" name="addition[1][mobile]" id='mobile' class="spc_input"></td>
						</tr>                        
						<tr>
							<td>{$lang.fax}：</td>
							<td class="t_left"><input value="{$rs.fax}" type="text" name="addition[1][fax]" id='fax' class="spc_input"></td>
						</tr>
						<tr>
							<td>{$lang.comments}：</td>
							<td class="t_left"><textarea id="comments" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
						</tr>
   </tbody>          
</table>
</form> 