<form action="{'ReturnProcessFee/insert'|U}" method="POST" onsubmit="return false">
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
                            <input type="hidden" name="warehouse_id" value="{$rs.warehouse_id}" onchange="showWCurrency(this,'');">
                            <input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$rs.w_name}" jqac />__*__	
                        </td>
                    </tr>
                {/if}
				<tr>
					<td class="width15">{$lang.process_fee_no}：</td>
					<td class="t_left">
						<input type="text" name="return_process_fee_no" id='return_process_fee_no' class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.process_fee_name}：</td>
					<td class="t_left">
						<input type="text" name="return_process_fee_name" id='return_process_fee_name' class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.shipping_type}：</td>
					<td class="t_left">
						{select data=C('SHIPPING_TYPE') name="shipping_type" empty=true combobox=1}__*__
					</td>
				</tr>
				<tr>
					<td colspan=2 style="padding:0 350px 0 120px">{include file="ReturnProcessFee/detail.tpl"}</td>
				</tr>
				<tr>
					<td valign="top">{$lang.comments}：</td>
					<td class="t_left">
						<textarea name="comments"></textarea>__*__
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</form> 