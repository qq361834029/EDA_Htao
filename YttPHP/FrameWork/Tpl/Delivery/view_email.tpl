<div style="border: 1px solid #89A5C5;padding:5px 10px 10px 10px;margin:0 auto;height:auto;font-size:12px;">
<table cellspacing="0" cellpadding="0" style="font-size:12px;line-height:30px;" width="99%">
    <tbody> 
         	<tr>
    			<th style="border-bottom:#ccc 1px dashed;font-weight:bold; color:#366599;text-align:left;">
    			<div style="width:100%; float:left; height:30px; line-height:30px;">
    				<div style="float:left;width:35%;text-indent:8px;font-size:14px;text-align:left;">{$lang.delivery_basic}</div>
    				<div style="float:right;color:#ff0000; width:400px;text-align:right; padding-right:5px;font-weight:normal;font-size:12px;padding-right:28px;">{$lang.delivery_no}：{$rs.delivery_no}</div>
    			</div></th>
    		</tr> 
         <tr><td>
         <div style="float:left;line-height:28px;width:94%;padding:10px 40px;">
        <ul>  
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.client_name}：{$rs.client_name}</li>
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.sale_no}：{$rs.orders_no}</li>
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.currency}：{$rs.currency_no}</li>
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.moblie_phone}：{$rs.mobile}</li>
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.delivery_date}：{$rs.fmd_delivery_date}</li> 
		{if 'delivery.multi_delivery'|C==1}
		<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;"><input type="checkbox" name="sale_finish" id="sale_finish" value="1" {if $rs.sale_finish==1} checked {/if} disabled>&nbsp;&nbsp;{$lang.sale_finish}</li> 
		{/if}
		</ul>
         </div>
         </td></tr>   
          <tr><th style="border-bottom:#ccc 1px dashed;padding-left:8px;font-weight:bold;color:#366599;text-align:left;font-size:14px;">{$lang.delivery_detail}</th></tr> 
           <tr><td height="8"></td></tr>   
          <tr><td>{include file="Delivery/detail_mail.tpl"}</td></tr> 
          <tr><td style="padding-top:10px;">
	          <table width="100%" cellspacing="0" cellpadding="0" border="0" style="line-height:30px;font-size:12px;">
				<tbody>
					<tr> 
					<td width="12%" valign="top" style="text-align:right!important;" >{$lang.comments}：</td>
					<td class="t_left" width="38%" valign="top" style="text-align:left!important;" >{$rs.comments}</td>
					<td width="12%" valign="top" style="text-align:right!important;" >{$lang.receive_addr}：</td>
					<td class="t_left"  width="38%" valign="top" style="text-align:left!important;" >{$rs.receive_addr}</td>
					</tr>
		</tbody>
		</table>
      </td></tr>                      
   </tbody>          
  </table> 
  {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
</div> 
