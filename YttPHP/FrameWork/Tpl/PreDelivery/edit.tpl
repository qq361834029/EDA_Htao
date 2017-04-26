<form action="{'PreDelivery/update'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
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
	<input type="hidden" name="id" id="id" value="{$rs.id}">
	<input type="hidden" name="sale_order_id" id="sale_order_id" value="{$rs.sale_info.id}">
	<input type="hidden" name="sale_date" id="sale_date" value="{$rs.sale_info.order_date}">
<ul> 
<li>{$lang.client_name}：{$rs.client_name}	</li>
<li>{$lang.sale_no}：{$rs.sale_info.sale_order_no}</li>
<li>{$lang.expect_shipping_date}：{$rs.sale_info.fmd_expect_shipping_date}</li>
<li>{$lang.pre_delivery_date}： <input type="text" name="pre_delivery_date"  id="pre_delivery_date" value="{$rs.pre_delivery_date}" 
	class="Wdate spc_input" 
	{literal}
onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
{/literal} />__*__	
</li>
</ul> 
</ul>
         </div>
         </td></tr>   
          <tr><th>{$lang.pre_delivery_detail}</th></tr>  
          
          <tr><td>{include file="PreDelivery/detail.tpl"}</td></tr> 
				</tbody>
			 </table>
      </td></tr>                      
   </tbody>          
  </table>
  {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div> 
</form> 
