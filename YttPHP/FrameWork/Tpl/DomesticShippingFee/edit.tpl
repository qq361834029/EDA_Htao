<form action="{'DomesticShippingFee/update'|U}" method="POST" onsubmit="return false">
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
					<td class="width15">{$lang.shipping_fee_no}：</td>
					<td class="t_left">
						<input type="text" name="domestic_shipping_fee_no" id='domestic_shipping_fee_no' value="{$rs.domestic_shipping_fee_no}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.shipping_fee_name}：</td>
					<td class="t_left">
						<input type="text" name="domestic_shipping_fee_name" id='domestic_shipping_fee_name' value="{$rs.domestic_shipping_fee_name}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.transport_type}：</td>
					<td class="t_left">
                        {$rs.dd_transport_type}
{*						{select data=C('TRANSPORT_TYPE') name="transport_type" id='transport_type' value=$rs.transport_type empty=true combobox=1 onchange="changeTransportType(this.value)"}__*__*}
					</td>
				</tr>
				<tr>
					<td colspan=2 style="padding:0 350px 0 120px" id="detail_table"></td>
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
<div class="none">
	{include file="DomesticShippingFee/detail.tpl"}
</div>