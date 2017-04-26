<form action="{'InitStorage/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.init_basic}</div>
    			</div></th>
    		</tr>
    		<tr><td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.init_date}：<input type="text" name="init_storage_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
				</li>
				{warehouse type="li" title=$lang.warehouse hidden=["name"=>"warehouse_id"]  name="warehouse_name" require="1"}
    			{currency data=C('currency') view=true name='currency_id' type='li' title=$lang.currency}
    			</td>
			</tr>
    		<tr>
    			<th >{$lang.init_detail}</th>
    		</tr>
    	   <tr><td>{include file="InitStorage/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td valign="top" class="t_left" width="80%"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

