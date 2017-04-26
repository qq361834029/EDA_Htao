<form method="POST" action="{'FundsClass/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
		<tr>
			<td>{$lang.relation_object}：</td>
			<td class="t_left">
				{select data=C('CFG_PAY_RALATION_OBJECT') name="relation_object" empty=true combobox=1}__*__
			</td>
		</tr>  			
		<tr>
			<td>{$lang.funds_class_type}：</td>
			<td class="t_left">
				{radio data=C('FUNDS_TYPE') name="pay_type"}__*__
			</td>
		</tr>  
		<tr>
			<td class="width10">{$lang.funds_class_name}：</td>
			<td class="t_left">
				<input type="text" name="pay_class_name" id="pay_class_name" class="spc_input" >__*__
			</td>
		</tr>     
		<tr>
			<td>{$lang.funds_class_relation_type}：</td>
			<td class="t_left">
				{select data=C('FUNDS_RELATED_DOC_NO') name="relation_type" combobox=1 empty=true}
			</td>
		</tr>	
		<tr>
		 <td valign="top">{$lang.comments}：</td>
		 <td class="t_left"><textarea name="comments"></textarea>
		 </td>
	   </tr>		
		</tbody>
		</table>
</div>
</form>
