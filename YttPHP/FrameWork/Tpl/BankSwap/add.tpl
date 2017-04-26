<form action="{'BankSwap/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody> 
	<tr>
	      <td>{$lang.swap_date}：</td>
	      <td class="t_left">
	      <input type="text" name="delivery_date" value="{$rs.delivery_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td>
	    </tr>          
	<tr>
		<td class="width15">{$lang.out_swap_account_name}：</td>
		<td class="t_left">
			<input type="hidden" name="out_bank_id" id="out_bank_id" value="{$rs.out_bank_id}" onchange="getCurrencyIdByBank(this, 'out');">
			<input type="text" name="out_account_name" id='out_account_name' url="{'AutoComplete/bank'|U}" jqac>__*__
		</td>
	</tr>
	<tr>
		<td class="width15">{$lang.out_swap_currency_name}：</td>
		<td class="t_left">
            <span id="out_currency"></span>
            <span class="none">{currency data=C('COMPANY_CURRENCY') name="out_currency_id" id="out_currency_id" combobox=1}__*__</span>
		</td>
	</tr>      
	<tr>
	      <td>{$lang.out_swap_money}：</td>
	      <td class="t_left">
              <input type="text" name="out_money" id="out_money" onkeyup="calculateSwapMoney('out')" class="spc_input" autocomplete="off" />__*__</td>
    	</tr>  
	<tr>
		<td>{$lang.in_swap_account_name}：</td>
		<td class="t_left" id="show_in_bank">
			<input type="hidden" name="in_bank_id" id="in_bank_id" onchange="getCurrencyIdByBank(this, 'in');">
			<input type="text" name="in_account_name" id='in_account_name' url="{'AutoComplete/bank'|U}" jqac>__*__
		</td>
	</tr> 
	<tr>
		<td class="width15">{$lang.in_swap_currency_name}：</td>
		<td class="t_left">
            <span id="in_currency"></span>
            <span class="none">{currency data=C('COMPANY_CURRENCY') name="in_currency_id" id="in_currency_id" combobox=1}__*__</span>
		</td>
	</tr> 
    	<tr>
	      <td>{$lang.rate}：</td>
	      <td class="t_left">
              <input type="text" name="rate" id="rate" onkeyup="calculateSwapMoney('rate')" class="spc_input" autocomplete="off" />__*__</td>
    	</tr>  	
    <tr>
	      <td>{$lang.in_swap_money}：</td>
	      <td class="t_left">
              <input type="text" name="in_money" id="in_money" onkeyup="calculateSwapMoney('in')" class="spc_input" autocomplete="off" />__*__</td>
    	</tr>  
    	<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="in_comments" rows="5" cols="60"></textarea></td>
		</tr>
		</tbody>
		</table>
</div>
</form>
