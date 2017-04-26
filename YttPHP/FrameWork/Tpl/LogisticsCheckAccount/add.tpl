<form action="{'LogisticsCheckAccount/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
		<tbody> 
			<input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" class="spc_input" > 
			<input type="hidden" name="basic_id" id="basic_id" value="{C(DEFAULT_BASIC_ID)}" class="spc_input" >  
		<tr>
			<td class="width10">{$lang.logistics_name}：</td>
			<td class="t_left">
			<input type="hidden" name="comp_id" id="comp_id" value="{$smarty.post.query.id}" >
			<input type="text" name="comp_name" id='comp_name' url="{'AutoComplete/logistics'|U}" jqac>__*__ 
			</td>
		</tr> 
		<tr>
	      <td>{$lang.date}：</td>
	      <td class="t_left">
	      <input type="text" name="paid_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td>
	    </tr> 
	    {currency data=C('LOGISTICS_CURRENCY') name="currency_id" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="1"  } 
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
