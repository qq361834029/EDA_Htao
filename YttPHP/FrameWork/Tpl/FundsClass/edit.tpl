<form method="POST" action="{'FundsClass/update'|U}" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>			
		<tr>
			<td>{$lang.relation_object}：</td>
			<td class="t_left">
				{select data=C('CFG_PAY_RALATION_OBJECT') name="relation_object" value=$rs.relation_object empty=true combobox=1}__*__
			</td>
		</tr>  				
		<tr>
			<td>{$lang.pay_type}：</td>
			<td class="t_left">{radio data=C('FUNDS_TYPE') name="pay_type" value=$rs.pay_type}</td>
		</tr>  
		<tr>
			<td class="width10">{$lang.pay_class_name}：</td>
			<td class="t_left">
				<input type="text" name="pay_class_name" id="pay_class_name" value="{$rs.pay_class_name}" class="spc_input" >__*__
			</td>
		</tr>     
		<tr>
			<td>{$lang.funds_class_relation_type}：</td>
			<td class="t_left">
				{select data=C('FUNDS_RELATED_DOC_NO') name="relation_type" combobox=1 value=$rs.relation_type empty=true}
			</td>
		</tr>	
		<tr>
		 <td valign="top">{$lang.comments}：</td>
		 <td class="t_left"><textarea name="comments">{$rs.edit_comments}</textarea>
		 </td>
	   </tr>		
		</tbody>
</table>
</div>
</form>
