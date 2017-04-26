<script>
	$(document).ready(function(){
		$dom.find("#accord_type").trigger("click");
	});
</script>
<form action="{'ProcessFee/insert'|U}" method="POST" onsubmit="return false">
	{wz action="save,list,reset"}
	<div class="add_box">
		<table cellspacing="0" cellpadding="0" class="add_table">
			<tbody>
				<tr>
					<td>{$lang.type}：</td>
					<td class="t_left">{radio data=C('ACCORD_TYPE') name="accord_type" id="accord_type" initvalue="1" onclick="AccordType(this.value)"}</td>
				</tr>    
                <tr>   
                    <td class="width10">{$lang.order_type}：</td>
                    <td class="t_left">
                        <input type="hidden" name="order_type" value="0">
                        <input name="temp[order_type_name]" url="{'AutoComplete/orderTypeName'|U}" value="{$lang.all}" jqac />__*__	
                    </td>
                </tr>
                {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
                    <input type="hidden" name="warehouse_id" id="warehouse_id" value="{$login_user.company_id}">
                    <tr>
                        <td class="width10">{$lang.currency}：</td>
                        <td class="t_left">
                            {$currency_no}
                        </td>
                    </tr>
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
						<input type="text" name="process_fee_no" id='process_fee_no' class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.process_fee_name}：</td>
					<td class="t_left">
						<input type="text" name="process_fee_name" id='process_fee_name' class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.shipping_type}：</td>
					<td class="t_left">
						{select data=C('SHIPPING_TYPE') name="shipping_type" empty=true combobox=1}__*__
					</td>
				</tr>
				<tr id="accord_weight" style="display:none;">
					<td colspan=2 style="padding:0 500px 0 120px">{include file="ProcessFee/detail.tpl"}</td>
				</tr>
				<tr class="accord_quantity">
					<td>{$lang.weight_interval}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][weight_begin]" id="weight_begin" class="spc_input" /> {$lang.to} <input type="text" name="detail[1][weight_end]" id="weight_end" class="spc_input" /> {C('WEIGHT_UNIT')}__*__
					</td>
				</tr>    
				<tr class="accord_quantity">
					<td>{$lang.process_fee}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][price]" id="price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency" style="display: none"></span>
					</td>
				</tr>
				<tr class="accord_quantity">
					<td>{$lang.step_price_by_quantity}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][step_price]" id="step_price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency" style="display: none"></span>
					</td>
				</tr>
                <tr class="accord_quantity">
					<td>{$lang.max_price}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][max_price]" id="max_price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency" style="display: none"></span>
					</td>
				</tr>
				<tr>
					<td valign="top">{$lang.comments}：</td>
					<td class="t_left">
						<textarea name="comments"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</form> 