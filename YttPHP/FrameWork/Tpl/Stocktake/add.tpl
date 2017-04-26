<form action="{'Stocktake/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.stocktake_basic}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
	    		{$lang.stocktake_employee}：
	    		<input type="hidden" name="employee_id" id="employee_id" >
	    		<input type="text" id="employee_name" name="client_name" url="{'AutoComplete/employee'|U}" jqac>
	    		{quicklyAdd module="Employee"}
    		</li>
			{warehouse type="li" title=$lang.warehouse hidden=["name"=>"warehouse_id"]  name="warehouse_name" require=""}
    		<li>{$lang.stocktake_date}：
				<input type="text" name="stocktake_date" class="Wdate spc_input" onClick="WdatePicker()" value="{$this_day}"/>__*__</li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.stocktake_detail}</th>
    		</tr>
    	   <tr><td>{include file="Stocktake/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

