{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.common_adjust_basic}</div>
    				<div class="afr">{$lang.adjust_no}：{$rs.adjust_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.adjust_date}：{$rs.fmd_adjust_date}
				</li>
				<li>
					{$lang.delivery_no}：{$rs.instock_no}
				</li>
    			{currency data=C('currency') view=true name='currency_id' type='li' title=$lang.currency}
    			</td>
			</tr>
    		<tr>
    			<th >{$lang.stat_adjust_detail}</th>
    		</tr>
    	   <tr><td>{include file="InstockImportAdjust/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="80%" valign="top" class="t_left">{$rs.edit_comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

