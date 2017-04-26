<form action="{'PreDelivery/insert'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
         <tr><th>{$lang.pre_delivery_basic}</th></tr>
         <tr><td>
         <div class="basic_tb">
          <ul> 
	<input type="hidden" name="id" id="id" value="">
	<input type="hidden" name="sale_order_id" id="sale_order_id" value="{$smarty.get.id}">
	<input type="hidden" name="sale_date" id="sale_date" value="{$rs.fmd_order_date}">
	<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}">
	<input type="hidden" name="basic_id" id="basic_id" value="{$rs.basic_id}">
	<input type="hidden" name="orders_no" id="orders_no" value="{$rs.sale_order_no}">           
 
<ul> 
<li>{$lang.client_name}：{$rs.client_name}	</li>
<li>{$lang.sale_no}：	{$rs.sale_order_no}</li>
<li>{$lang.expect_shipping_date}：{$rs.fmd_expect_shipping_date}</li>
<li>{$lang.pre_delivery_date}： <input type="text" name="pre_delivery_date"  id="pre_delivery_date" value="{$this_time}"
 
{if 'digital_format'|C==eur}
{literal} 
onClick="WdatePicker({dateFmt:'dd/MM/yy HH:mm:ss'})"
{/literal}
{else}
{literal} 
onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
{/literal}
{/if}  
	class="Wdate spc_input" />__*__	
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
  {staff}
</div>
</form> 
