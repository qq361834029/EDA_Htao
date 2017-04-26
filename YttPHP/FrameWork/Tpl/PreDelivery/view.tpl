{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
         <tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.pre_delivery_basic}</div>
    				<div class="afr">{$lang.pre_delivery_no}：{$rs.pre_delivery_no}</div>
    			</div></th>
    		</tr>
         <tr><td>
         <div class="basic_tb">
         <ul>  
			<li>{$lang.client_name}： {$rs.client_name}</li> 
			<li>{$lang.sale_no}：{$rs.sale_info.sale_order_no}</li>
			<li>{$lang.expect_shipping_date}：{$rs.sale_info.fmd_expect_shipping_date}</li>
			<li>{$lang.pre_delivery_date}： {$rs.fmd_pre_delivery_date}</li>  
		 </ul>
         </div>
         </td></tr>   
          <tr><th>{$lang.pre_delivery_detail}</th></tr> 
          {barcode}     
          <tr><td>{include file="PreDelivery/detail.tpl"}</td></tr> 
				</tbody>
			 </table>
      </td></tr>                      
   </tbody>          
  </table> 
  {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
</div> 
