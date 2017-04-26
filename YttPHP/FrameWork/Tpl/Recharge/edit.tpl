<form action="{'Recharge/editConfirm'|U}" method="POST" onsubmit="return false" style="height:75%;">
{wz action="confirm,reset"}
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="confirm_state" value="{$rs.confirm_state}">
<input type="hidden" name="money" value="{$rs.money}">
<input type="hidden" name="money_to" value="{$rs.money_to}">
<input type="hidden" id="currency_id" value="{$rs.currency_id}">
<div class="add_box" style="height:100%;">
<table cellspacing="0" cellpadding="0" class="add_table" style="margin:auto -100px auto 40px;width:auto;float:left;">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.edit_charge}</th>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.belongs_seller}：</td>
      		<td class="t_left">{$rs.factory_name}</td>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.warehouse_name}：</td>
      		<td class="t_left">{$rs.w_name}</td>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.recharge_date}：</td>
      		<td class="t_left">{$rs.recharge_date}</td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.currency_name}：</td>
      		<td class="t_left">{$rs.currency_no}</td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.bank_name}：</td>
      		<td class="t_left">{$rs.bank_name}</td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.recharge_money}：</td>
			<td class="t_left"><span id="money">{$rs.money}</span></td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.payment_document}：</td>
      		<td class="t_left">{showFiles from=$rs.pics}
			</td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.comment}：</td>
      		<td class="t_left">{$rs.comments}</td>
    	</tr> 
	</tbody>
</table>
<table cellspacing="0" cellpadding="0" class="add_table" style="width:auto;">
    <tbody>
		<tr>
    		<th colspan="2">{$lang.confirm_info}</th>
    	</tr> 
    	<tr>
			<td class="width10">{$lang.confirm_date}：</td>
			<td class="t_left"><input type="text" name="confirm_date" onchange="setRateMoneyTo();" value="{$rs.confirm_date|default:$this_day}" class="Wdate spc_input" onClick="WdatePicker({if 'digital_format'|C==eur}{literal}{dateFmt:'dd/MM/yy'}{/literal}{else}{literal}{dateFmt:'yyyy-MM-dd'}{/literal}{/if})" />__*__</td>
		</tr>
		<tr>
			<td>{$lang.currency_name}：</td>
			<td class="t_left">
				{currency data=C('COMPANY_CURRENCY') name="confirm_currency_id" onchange="setRateMoneyTo();" value="{$rs.confirm_currency_id|default:2}"}__*__
			</td>
		</tr>
		<tr>
      		<td class="width10">{$lang.rate}：</td>
      		<td class="t_left"><input type="text" name="opened_y" onkeyup="setMoneyToByRate();" value="{$rs.opened_y}" class="spc_input" >__*__</td>
    	</tr>
		<tr>
      		<td class="width10">{$lang.money_to}：</td>
			<td class="t_left"><span id="span_money_to">{$rs.money_to}</span></td>
    	</tr>
		<tr>
      		<td class="width10">{$lang.confirm_money}：</td>
      		<td class="t_left"><input type="text" name="confirm_money"  value="{$rs.money_to}" class="spc_input" >__*__</td>
    	</tr>
		<tr>
			<td class="width10" valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea  class="textarea_height80" name="confirm_comments"></textarea></td>
		</tr>
	</tbody>
</table>
</form> 
