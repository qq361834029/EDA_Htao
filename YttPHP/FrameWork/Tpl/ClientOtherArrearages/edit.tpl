<script type="text/javascript">
	function setBillingType(){
		var billing_type	= $dom.find('#billing_type').val();
		if (billing_type == {C('BILLING_TYPE_TOTAL')}) {
			$dom.find('#quantity').parent().hide();
			$dom.find('#price').parent().hide();
			$dom.find('#quantity').val('');
			$dom.find('#price').val('');
			$dom.find('#owed_money').removeClass('disabled').removeAttr('readonly');
		} else {
			$dom.find('#quantity').parent().show();
			$dom.find('#price').parent().show();
			$dom.find('#owed_money').addClass('disabled').attr('readonly', true);
		}
	}
	
	function  countOwedMoney() {
		var quantity		= $.cParseFloat($dom.find('#quantity').val());
		var price			= $.cParseFloat($dom.find('#price').val());	
		$dom.find('#owed_money').val((eval(quantity+'*'+price).toFixed(money_length))).trigger('keyup');
	}
	
	function  countReceivableMoney() {
		var owed_money		= $.cParseFloat($dom.find('#owed_money').val());
		var account_money	= $.cParseFloat($dom.find('#account_money').val());	
		$dom.find('#receivable_money').val((eval(owed_money+'-'+account_money).toFixed(money_length)));
	}	
	
	$(document).ready(function(){
		getFundsRelationDocInfo();
		setBillingType();
	});
</script>
<form action="{'ClientOtherArrearages/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" class="spc_input" > 
<input type="hidden" name="basic_id" id="basic_id" value="{C(DEFAULT_BASIC_ID)}" class="spc_input" > 
<input type="hidden" name="id" id="id" value="{$list.id}" class="spc_input" > 
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>  
    	<tr>
    		<th colspan="4">{$lang.basic_info}</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<div class="basic_tb">  
				<ul> 
					<li>
						{$lang.factory_name}：
						<input type="hidden" name="comp_id" id="comp_id" value="{$list.comp_id}">
                        <input type="text" name="comp_name" id='comp_name' value="{$list.comp_name}" disabled="disabled" class="spc_input disabled">
					</li>
					{company  type="li" title=$lang.basic_name
					hidden=['name'=>'basic_id','id'=>'basic_id']
					name='basic_name'  require="1"
					}					
					<li>
						{$lang.funds_date}： 
						<input type="text" name="paid_date" value="{$list.fmd_paid_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
					</li>
					<li>
						{$lang.funds_class}：  
                        <input type="hidden" name="pay_class_id" id="pay_class_id" value="{$list.pay_class_id}" onchange="setFundsRelationDoc();" />
                        <input type="text" url="{'/AutoComplete/fundsClassName'|U}" where="{" to_hide=1 and relation_object=2 and pay_type=2 "|urlencode}" value="{$list.pay_class_name}" jqac>__*__ 
					</li>
					<li>
						{$lang.relation_doc_no}：
                        <input type="hidden" id="relation_type" name="relation_type" value="{$list.relation_type}" />
						<input type="hidden" name="object_id" value="{$list.object_id}" id="object_id" onchange="getFundsRelationDocInfo();" />
						<input type="text" name="reserve_id" id="reserve_id" value="{$list.account_no}"  url="{"/AutoComplete/fundsRelationDocNo/relation_type/`$list.relation_type`"|U}" where="factory_id={$list.comp_id}" jqac><span id="reserve_require_span">__*__</span>
					</li>
					<li>{$lang.billing_type}：
						{select data=C('BILLING_TYPE') name="billing_type" initvalue=$list.billing_type id="billing_type" empty=true combobox=1  onchange="setBillingType()"}__*__
					</li>
                    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                    <li style="display: none;">
                        {$lang.warehouse_name}：
                        <input value="{$list.warehouse_id}" type="hidden" id="warehouse_id" name="warehouse_id">
                        <input value="" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__
                    </li>
                    {else}
                        <input value="{$warehouse_id}" type="hidden" name="warehouse_id">
                    {/if}
					{currency data=C('CLIENT_CURRENCY') name="currency_id" initvalue=$list.currency_id id="currency_id" type='li' title=$lang.funds_currency require="1"} 
					<li>{$lang.quantity}：
                        <input type="text" id="quantity" name="quantity" value="{$list.dml_quantity}" onkeyup="countOwedMoney()" autocomplete="off" class="spc_input" />__*__
					</li>					
					<li>{$lang.price_per_unit}：
                        <input type="text" id="price" name="price" value="{$list.price}" onkeyup="countOwedMoney()" autocomplete="off" class="spc_input" />__*__
					</li> 
				</ul>
			</div>
		</td>
	</tr>
    	<tr>
    		<th colspan="4">{$lang.funds_info}</th>
    	</tr>
    	<tr>
		<td colspan="4" class="t_center">
    			<div class="basic_tb">  
				<ul> 
					<li>{$lang.owed_money}：
                        <input type="text" id="owed_money" name="owed_money" value="{$list.dml_owed_money}" onkeyup="countReceivableMoney()" autocomplete="off" class="spc_input" />__*__
					</li> 
					<li>{$lang.account_money}：
						<input type="text" id="account_money" name="account_money" value="{$list.dml_discount_money}" onkeyup="countReceivableMoney()" autocomplete="off" class="spc_input" />
					</li> 
					<li>{$lang.receivable_money}：
						<input type="text" id="receivable_money" name="money" value="{$list.dml_original_money}" class="spc_input disabled" readonly="" />__*__
					</li> 
				</ul>
			</div>			
		</td>
    	</tr> 	
    	<tr id="relation_doc_title">
    		<th colspan="4">{$lang.funds_class_relation_type}{$lang.info}</th>
    	</tr>
    	<tr id="relation_doc_content">
			<td colspan="4">
			</td>
    	</tr>  
    	<tr id="relation_doc_title">
    		<th colspan="4">{$lang.other_info}</th>
    	</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.comments}：</td>
	   					<td colspan="3" class="t_left" valign="top">
							<textarea name="comments" id="comments" class="textarea_height80">{$list.edit_comments}</textarea>
						</td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	
 	</tbody>
</table>
{staff}
</div>
</form>