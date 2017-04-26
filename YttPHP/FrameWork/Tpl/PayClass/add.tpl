<form method="POST" action="{'PayClass/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
		<tr>
			<td>{$lang.pay_type}：</td>
			<td class="t_left">
				<input type="radio" name="pay_type" checked value="1"/>{$lang.outlay}
				<input type="radio" name="pay_type" value="2"/>{$lang.income} 
			</td>
		</tr>  
		<input type="hidden" name="relation_object" value="1"/>
		<tr>
			<td class="width10">{$lang.pay_class_name}：</td>
			<td class="t_left">
				<input type="text" name="pay_class_name" id="pay_class_name" class="spc_input" >__*__
			</td>
		</tr>     				
		</tbody>
		</table>
</div>
</form>
