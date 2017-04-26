<form action="{'RateInfo/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="id" value="{$rs.id}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.edit_rate}</th>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.date}：</td>
      		<td class="t_left">{$rs.fmd_rate_date}</td>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.from_currency}：</td>
      		<td class="t_left">{$rs.currency_from}</td>
    	</tr> 
    	<tr>
      		<td class="width10">{$lang.to_currency}：</td>
      		<td class="t_left">{$rs.currency_to}</td>
    	</tr> 
     	<tr>
      		<td class="width10">{$lang.rate}：</td>
      		<td class="t_left"><input type="text" name="opened_y" value="{$rs.opened_y}" class="spc_input" >__*__</td>
    	</tr>
    	 
	</tbody>
</table>
</form> 
