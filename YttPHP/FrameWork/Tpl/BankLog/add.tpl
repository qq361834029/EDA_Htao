<form action="{'BankLog/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody> 
	<input type="hidden" name="paid_type" id="paid_type" value="1" class="spc_input" > 
	<tr>
	      <td>{$lang.date}：</td>
	      <td class="t_left">
	      <input type="text" name="delivery_date" value="{$rs.delivery_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td>
	</tr>
	 {currency data=C('COMPANY_CURRENCY') name="currency_id" onchange="getBankByCurrency(this);" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="1" }
	{if C('BANK_CASH')==2}
	<tr>
	      <td>{$lang.relevance_cash}：</td>
	      <td class="t_left">
	      <input type="radio" name="relevance_cash" value="1" checked onchange="javascript:$dom.find('#td_bank_name').show()"/>{$lang.yes}
	      <input type="radio" name="relevance_cash" value="2" onchange="javascript:$dom.find('#td_bank_name').hide();$dom.find('#bank_id').val('')"/>{$lang.no}__*__
	      </td>
	</tr>
	{else}
	    <input type="hidden" name="relevance_cash" id="relevance_cash" value="{C('BANK_CASH')}" >
	{/if}
	<tr>
	      <td>{$lang.save_draw_type}：</td>
	      <td class="t_left">
	      <input type="radio" name="income_type" value="1"  checked/>{$lang.save_type}
	      <input type="radio" name="income_type" value="-1" />{$lang.withdraw}__*__
	      </td>
	</tr>
	<tr id="td_bank_name">
		<td>{$lang.bank_name}：</td>
		<td class="t_left" id="bank_id">
			<input type="hidden" name="bank_id" id="in_bank_id" value="{$smarty.post.query.id}">
			<input type="text" name="account_name" id='account_name' url="{'AutoComplete/bank'|U}" jqac>__*__
		</td>
	</tr>
	<tr>
	      <td>{$lang.money}：</td>
	      <td class="t_left">
	      <input type="text" name="money" id="money" value="" class="spc_input" onkeyup="getTotal(this);">__*__</td>
    	</tr>  
    	<tr>
	      <td>{$lang.other_cost}：</td>
	      <td class="t_left">
	      <input type="text" name="other_cost" id="other_cost" value="" class="spc_input" /></td>
    	</tr>  
    	<tr>
		<td valign="top">{$lang.comments}：</td>
		<td class="t_left"><textarea name="comments" rows="5" cols="60">{$rs.comments}</textarea></td>
	</tr>
	</tbody>
	</table>
</div>
</form>