{wz}
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
	    		<li>{$lang.transfer_date}：{$rs.fmd_transfer_date}</li>
    			
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
					<td width="80%" valign="top" class="t_left">{$rs.comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

