{wz is_update=false print_width=1500}
<div class="add_box" {if $rs.confirm_state == 1} style="height:100%;"{/if}>
<table cellspacing="0" cellpadding="0" class="add_table" {if $rs.confirm_state == 1} style="margin:auto -100px auto 40px;width:auto;float:left;"{/if}>
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.view}</th>
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
      		<td class="t_left">{$rs.money}</td>
    	</tr> 
		<tr>
      		<td class="width10">{$lang.payment_document}：</td>
      		<td class="t_left">{showFiles from=$rs.pics}
			</td>
    	</tr> 
		<tr>
      		<td class="width10">{{$lang.comment}}：</td>
      		<td class="t_left">{$rs.comments}</td>
    	</tr> 
	</tbody>
</table>
{if $rs.confirm_state == 1}
<table cellspacing="0" cellpadding="0" class="add_table" style="width:auto;">
    <tbody>
		<tr>
    		<th colspan="2">{$lang.confirm_info}</th>
    	</tr> 
    	<tr>
			<td class="width10">{$lang.confirm_date}：</td>
			<td class="t_left">{$rs.confirm_date}</td>
		</tr>
		<tr>
			<td>{$lang.currency_name}：</td>
			<td class="t_left">{$rs.confirm_currency_no}</td>
		</tr>
		<tr>
      		<td class="width10">{$lang.rate}：</td>
      		<td class="t_left">{$rs.opened_y}</td>
    	</tr>
		<tr>
      		<td class="width10">{$lang.money_to}：</td>
			<td class="t_left">{$rs.money_to}</td>
    	</tr>
		<tr>
      		<td class="width10">{$lang.confirm_money}：</td>
      		<td class="t_left">{$rs.confirm_money}</td>
    	</tr>
		<tr>
      		<td class="width10">{$lang.comments}：</td>
      		<td class="t_left">{$rs.confirm_comments}</td>
    	</tr>
	</tbody>
</table>
{/if}


