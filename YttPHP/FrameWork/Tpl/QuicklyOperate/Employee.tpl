<form action="{'Employee/insert'|U}" method="POST"  onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
	    <tr>
    		<th colspan="2">{$lang.employee_message}</th>
    	</tr>
		<tr>
			<td class="width20">{$lang.employee_no}：</td>
			<td class="t_left"><input type="text" name="employee_no" value="{$max_no}"  {$is_auto_no}>__*__</td>
		</tr>
		<tr>
			<td>{$lang.employee_name}：</td>
			<td class="t_left">
				<input type="text" name="employee_name" id="employee_name" value="{$rs.employee_name}" class="spc_input" >__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.sex}：</td>
			<td class="t_left">
				<input type="radio" name="sex"   checked value="1"/>{$lang.man}
				<input type="radio" name="sex"   {if $rs.sex==2} checked{/if} value="2"/>{$lang.woman}__*__
			</td>
		</tr>  
		<tr>
	      	<td>{$lang.entry_date}：</td>
	      	<td class="t_left">
	      		<input type="text" name="entry_date" value="{$rs.entry_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
	      	</td>
	    </tr>
	    <tr>
    		<th colspan="2">{$lang.add_moe}[<a href="javascript:;" onclick="$.quicklyMore(this)">{$lang.add_open}</a>]</th>
    	</tr>
	    </tbody></table>
    	
    	<table cellspacing="0" cellpadding="0" class="table_autoshow_hidden" align="center">	
		{company 
			type="tr"  id="basic_name" name="basic_name" title=$lang.basic_name
			hidden=["id"=>"basic_id","name"=>"basic_id"] 
			}
	    <tr>
	    	<td>{$lang.phone}：</td>
	      	<td class="t_left"><input type="text" name="phone"  value="{$rs.phone}" class="spc_input"/></td>
	    </tr>	
	    <tr>
	      	<td>{$lang.email}：</td>
	      	<td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input"/></td>
	    </tr>	
	    
	    <tr>
	      	<td>{$lang.leave_date}：</td>
	      	<td class="t_left"><input type="text" name="leave_date" value="{$rs.leave_date}" class="Wdate spc_input" onClick="WdatePicker()" /></td>
	    </tr>	
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60">{$rs.comments}</textarea></td>
		</tr>	        	        				
	</tbody>
</table>
</div>
</form> 

