{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.init_basic}</div>
    				<div class="afr">{$lang.init_no}：{$rs.init_storage_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.init_date}：{$rs.fmd_init_storage_date}
				</li>
				<li>{$lang.warehouse}：{$rs.w_name}</li>
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
					<td valign="top" class="t_left" width="80%">{$rs.comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

