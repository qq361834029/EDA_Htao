<form action="{'BankRemittance/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody> 
		<input type="hidden" name="paid_type" id="paid_type" value="3" class="spc_input" >   
	 {currency data=C('COMPANY_CURRENCY') name="currency_id" onchange="getBankByCurrency(this);" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="1" }  
	<tr>
		<td class="width15">{$lang.out_remittance_account_name}：</td>
		<td class="t_left">
			<input type="hidden" name="out_bank_id" id="out_bank_id" value="{$smarty.post.query.id}" onchange="getBankById(this);">
			<input type="text" name="out_account_name" id='out_account_name' url="{'AutoComplete/bank'|U}" jqac>__*__
		</td>
	</tr>
	<tr>
		<td>{$lang.in_remittance_account_name}：</td>
		<td class="t_left" id="show_in_bank">
			<input type="hidden" name="in_bank_id" id="in_bank_id" value="{$smarty.post.query.id}">
			<input type="text" name="in_account_name" id='in_account_name' url="{'AutoComplete/bank'|U}" jqac>__*__
		</td>
	</tr> 
	<tr>
	      <td>{$lang.date}：</td>
	      <td class="t_left">
	      <input type="text" name="delivery_date" value="{$rs.delivery_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td>
	    </tr>  
	    <tr>
	      <td>{$lang.execute_quantity}：</td>
	      <td class="t_left">
	      <input type="text" name="quantity" id="quantity" value="1" class="spc_input" onkeyup="getTotal(this);">__*__</td>
    	</tr>
	<tr>
	      <td>{$lang.money}：</td>
	      <td class="t_left">
	      <input type="text" name="money" id="money" value="" class="spc_input" onkeyup="getTotal(this);">__*__</td>
    	</tr>  
    	<tr>
	      <td>{$lang.total_money}：</td>
	      <td class="t_left" id="sum_money">0</td>
    	</tr>
    	<tr>
	      <td>{$lang.other_cost}：</td>
	      <td class="t_left">
	      <input type="text" name="other_cost" id="other_cost" value="" class="spc_input"  onkeyup="getTotal(this);"></td>
    	</tr>  
		<tr>
	      <td>{$lang.sum_other_cost}：</td>
	      <td class="t_left" id="sum_other_cost">0</td>
    	</tr>
    	<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60">{$rs.comments}</textarea></td>
		</tr>
		</tbody>
		</table>
</div>
</form>
