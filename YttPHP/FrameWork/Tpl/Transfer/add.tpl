<form action="{'Transfer/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.transfer_basic}</div>
    			</div></th>
    		</tr>
    		<tr><td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.transfer_date}：<input type="text" name="transfer_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
				</li>
    			
    			</td>
			</tr>
    		<tr>
    			<th >{$lang.transfer_detail}</th>
    		</tr>
    	   <tr><td>{include file="Transfer/detail.tpl"}</td></tr>
	
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

