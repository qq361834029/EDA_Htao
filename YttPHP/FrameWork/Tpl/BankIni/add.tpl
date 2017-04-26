<form action="{'BankIni/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td>{$lang.fund_type}：</td>
			<td class="t_left">
			<input type="radio" name="paid_type" value="3" onchange="javascript:$dom.find('#tr_bank').show();$dom.find('#currency_select').hide();" checked/>{$lang.bank}
			<input type="radio" name="paid_type" value="1" onchange="javascript:$dom.find('#tr_bank').hide();$dom.find('#bank_id').val('');$dom.find('#account_name').val('');getCurrencyIdByBank();getCurrencyIdComplete();$dom.find('#currency').html();"/>{$lang.cash}__*__
		</tr>
		<tr id="tr_bank">
			<td>{$lang.bank_name}：</td>
			<td class="t_left">
			<input type="hidden" name="bank_id" id="bank_id" value="" onchange="getCurrencyIdByBank(this);" >
			<input type="text" name="account_name" id='account_name' url="{'AutoComplete/bank'|U}" jqac>__*__ 
			</td>
		</tr>
		<tr>
		      <td>{$lang.currency_name}：</td>
		      <td class="t_left"><span id="currency"></span><span id="currency_select" class="none">{currency data=C('COMPANY_CURRENCY') name="currency_id" id="currency_id" combobox=1}__*__</span>
		      </td>
		</tr>
		<tr>
			<td>{$lang.date}：</td>
			<td class="t_left">
			<input type="text" name="delivery_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td>
		</tr>  
		<tr>
		      <td >{$lang.money}：</td>
		      <td class="t_left">
		      <input type="text" name="money" id="money" value="" class="spc_input">__*__</td>
		</tr>  
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" class="textarea_height80">{$rs.comments}</textarea></td>
		</tr>
		</tbody>
		</table>
</div>
</form>