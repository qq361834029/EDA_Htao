<form action="{'ReturnProcessFee/update'|U}" method="POST" onsubmit="return false">
	<input type="hidden" name="id" value="{$rs.id}">
	<input type="hidden" id='flow' value="returnProcessFee">
	{wz action="save,list,reset"}
	<div class="add_box">
		<table cellspacing="0" cellpadding="0" class="add_table">
			<tbody>
                {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
                    <input type="hidden" name="warehouse_id" id="warehouse_id" value="{$login_user.company_id}">
                {else}
                    <tr>
                        <td class="width10">{$lang.belongs_warehouse}：</td>
                        <td class="t_left">
                            <input id="warehouse_id" value="{$rs.warehouse_id}" type="hidden" name="warehouse_id" class="valid-required" onchange="showWCurrency(this,'');">
                            <input id="warehouse_name" value="{$rs.w_name}" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__
                        </td>
                    </tr>						
                {/if}	
				<tr>
					<td class="width15">{$lang.process_fee_no}：</td>
					<td class="t_left">
						<input type="text" name="return_process_fee_no" id='return_process_fee_no' value="{$rs.return_process_fee_no}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.process_fee_name}：</td>
					<td class="t_left">
						<input type="text" name="return_process_fee_name" id='return_process_fee_name' value="{$rs.return_process_fee_name}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.shipping_type}：</td>
					<td class="t_left">
						{select data=C('SHIPPING_TYPE') name="shipping_type" value=$rs.shipping_type empty=true combobox=1}__*__
					</td>
				</tr>
				<tr>
					<td colspan=2 style="padding:0 350px 0 120px">{include file="ReturnProcessFee/detail.tpl"}</td>
				</tr>
				<tr>
					<td valign="top">{$lang.comments}：</td>
					<td class="t_left">
						<textarea name="comments">{$rs.edit_comments}
					</textarea>
				</td>
				</tr>
			</tbody>
		</table>
	</div>
</form> 