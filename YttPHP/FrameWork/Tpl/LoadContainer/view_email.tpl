<form action="{'LoadContainer/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
 
<div style="border: 1px solid #89A5C5;padding:5px 10px 10px 10px;margin:0 auto;height:auto;font-size:12px;">
<table cellspacing="0" cellpadding="0"   width="99%" style="font-size:12px;line-height:30px;" width="99%">
    	<tbody>  
    		<tr>
    			<th style="border-bottom:#ccc 1px dashed;font-weight:bold; color:#366599;text-align:left;">
    			<div style="width:100%; float:left; height:30px; line-height:30px;">
    				<div style="float:left;width:35%;text-indent:8px;font-size:14px;text-align:left;">{$lang.load_container_basic}</div>
    				<div style="float:right;color:#ff0000; width:400px;text-align:right; padding-right:5px;font-weight:normal;font-size:12px;padding-right:28px;">{$lang.load_container_no}：{$rs.load_container_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div style="float:left;line-height:28px;width:94%;padding:10px 40px;">  
    		<ul> 
    		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;width:320px;">{$lang.container_no}：{$rs.container_no}</li>
    <li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;width:320px;">{$lang.trans_comp}：{$rs.logistics_name}</li>
   <li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;width:320px;">{$lang.load_date}：{$rs.fmd_load_date}</li>
    <li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;width:320px;">{$lang.delivery_date}：{$rs.fmd_delivery_date}</li>
     <li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;width:320px;">{$lang.expect_arrive_date}：{$rs.fmd_expect_arrive_date}</li>
    		</ul>
    		</div>
    		</td></tr>
    		<tr>
    			<th style="border-bottom:#ccc 1px dashed;padding-left:8px;font-weight:bold;color:#366599;text-align:left;font-size:14px;">{$lang.load_container_detail}</th>
    		</tr>
    	  <tr><td height="8"></td></tr>   
    	   <tr><td>
			{include file="LoadContainer/detail_email.tpl"}
			</td></tr>
	
    		<tr><td style="padding-top:10px;">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0" style="line-height:30px;font-size:12px;">
					<tr>
					<td width="15%" style="text-align:right!important;"  valign="top">{$lang.comments}：</td>
					<td width="35%" valign="top" style="text-align:left!important;" >{$rs.edit_comments}</td>
					<td>
					{include file="LoadContainer/factoryTotal_email.tpl"}
				</td>
				</tr>
			 </table>
    		</td></tr>
    		<tr><td height="10"></td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

