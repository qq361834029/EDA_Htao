{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
         <tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.delivery_basic}</div>
    				<div class="afr">{$lang.delivery_no}：{$rs.delivery_no}</div>
    			</div></th>
    		</tr> 
         <tr><td>
         <div class="basic_tb">
        <ul>  
		<li>{$lang.client_name}：{$rs.client_name}</li>
		<li>{$lang.sale_no}：{$rs.orders_no}</li>
		</ul>
		<ul> 
		<li>{$lang.currency}：{$rs.currency_no}</li>
		</ul>
		<ul>
		<li>{$lang.moblie_phone}：{$rs.mobile}</li>
		<li>{$lang.delivery_date}：{$rs.fmd_delivery_date}</li> 
		{if 'delivery.multi_delivery'|C==1}
		<li><input type="checkbox" name="sale_finish" id="sale_finish" value="1" {if $rs.sale_finish==1} checked {/if}  disabled>&nbsp;&nbsp;{$lang.sale_finish}</li> 
		{/if}
		</ul>
         </div>
         </td></tr>   
          <tr><th>{$lang.delivery_detail}</th></tr> 
          {barcode}     
          <tr><td>{include file="DeliverySale/detail.tpl"}</td></tr> 
          <tr><td class="pad_top_10">
	          <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr> 
					<td width="12%" valign="top">{$lang.comments}：</td>
					<td class="t_left" width="38%" valign="top">{$rs.edit_comments}</td>
					<td width="12%" valign="top">{$lang.receive_addr}：</td>
					<td width="38%" class="t_left"valign="top">{$rs.receive_addr}</td>
					</tr>
					
		</tbody>
		</table>
      </td></tr>                      
   </tbody>          
  </table>
  {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
</div> 
