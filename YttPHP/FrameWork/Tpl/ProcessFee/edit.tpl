<script>
	$(document).ready(function(){
		var accord_type   =   $.cParseInt($dom.find("#accord_type:checked").val());
		AccordType(accord_type);
	});
</script>
<form action="{'ProcessFee/update'|U}" method="POST" onsubmit="return false">
	<input type="hidden" name="id" value="{$rs.id}">
	<input type="hidden" id='flow' value="processFee">
	{wz action="save,list,reset"}
	<div class="add_box">
		<table cellspacing="0" cellpadding="0" class="add_table">
			<tbody>
				<tr>
					<td>{$lang.type}：</td>
					<td class="t_left">{radio data=C('ACCORD_TYPE') name="accord_type" id="accord_type" value="`$rs.accord_type`" onclick="AccordType(this.value)"}</td>
				</tr>
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
                    <td class="width10">{$lang.order_type}：</td>
                    <td class="t_left">
                        <input type="hidden" name="order_type" value="{$rs.order_type}">
                        <input name="temp[order_type_name]" url="{'AutoComplete/orderTypeName'|U}" value="{if $rs.order_type>0}{$rs.order_type_name}{else}{$lang.all}{/if}" jqac />__*__	
                    </td>
                </tr>
				<tr>
					<td class="width15">{$lang.process_fee_no}：</td>
					<td class="t_left">
						<input type="text" name="process_fee_no" id='process_fee_no' value="{$rs.process_fee_no}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.process_fee_name}：</td>
					<td class="t_left">
						<input type="text" name="process_fee_name" id='process_fee_name' value="{$rs.process_fee_name}" class="spc_input" />__*__
					</td>
				</tr>
				<tr>
					<td>{$lang.shipping_type}：</td>
					<td class="t_left">
						{select data=C('SHIPPING_TYPE') name="shipping_type" value=$rs.shipping_type empty=true combobox=1}__*__
					</td>
				</tr>
				<tr id="accord_weight" style="display:none;">
					<td colspan=2 style="padding:0 500px 0 120px">{include file="ProcessFee/detail.tpl"}</td>
				</tr>
				{if $rs.accord_type==1}
				{foreach from=$rs.detail item=item key=index}
				<tr class="accord_quantity">
					<td>{$lang.weight_interval_with_unit}：</td>
					<td class="t_left">
						<input type="text" name="detail[{$index}][weight_begin]" value="{$item.edml_weight_begin}" class="spc_input" /> {$lang.to} <input type="text" name="detail[{$index}][weight_end]" value="{$item.edml_weight_end}" class="spc_input" /> {C('WEIGHT_UNIT')}__*__
					</td>
				</tr>    
				<tr class="accord_quantity">
					<td>{$lang.process_fee}：</td>
					<td class="t_left">
						<input type="text" name="detail[{$index}][price]" id="price" value="{$item.edml_price}" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
				<tr class="accord_quantity">
					<td>{$lang.step_price_by_quantity}：</td>
					<td class="t_left">
						<input type="text" name="detail[{$index}][step_price]" value="{$item.edml_step_price}" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
                <tr class="accord_quantity">
					<td>{$lang.max_price}：</td>
					<td class="t_left">
						<input type="text" name="detail[{$index}][max_price]" value="{$item.edml_max_price}" id="max_price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
				{/foreach}
				{else}
				<tr class="accord_quantity">
					<td>{$lang.weight_interval_with_unit}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][weight_begin]" class="spc_input" /> {$lang.to} <input type="text" name="detail[1][weight_end]" value="{$item.edml_weight_end}" class="spc_input" /> {C('WEIGHT_UNIT')}__*__
					</td>
				</tr>    
				<tr class="accord_quantity">
					<td>{$lang.process_fee}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][price]" id="price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
				<tr class="accord_quantity">
					<td>{$lang.step_price_by_quantity}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][step_price]" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
                <tr class="accord_quantity">
					<td>{$lang.max_price}：</td>
					<td class="t_left">
						<input type="text" name="detail[1][max_price]" id="max_price" class="spc_input"/>__*__
                        <span class="t_left" id="show_w_currency">{$rs.currency_no}</span>
					</td>
				</tr>
				{/if}
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