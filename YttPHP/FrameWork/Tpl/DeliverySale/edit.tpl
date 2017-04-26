<form action="{'Delivery/update'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<input type="hidden" name="sale_date" id="sale_date" value="{$rs.fmd_sale_date}">
    <tbody>
         <tr><th>{$lang.delivery_basic}</th></tr>
         <tr><td>
         <div class="basic_tb">
          <ul> 
			<input type="hidden" name="id" id="id" value="{$rs.id}">
		<li>{$lang.client_name}：{$rs.client_name}</li>
		<li>{$lang.sale_no}：{$rs.orders_no}</li>
		</ul>
		<ul> 
		<li>{$lang.currency}：{$rs.currency_no}</li>
		</ul>
		<ul>
		<li>{$lang.moblie_phone}：<input type="text" name="mobile" id="mobile" value="{$rs.mobile}" class="spc_input"></li>
		<li>{$lang.delivery_date}：<input type="text" name="delivery_date"  id="delivery_date" value="{$rs.fmd_delivery_date}" class="Wdate spc_input" 
{if 'digital_format'|C==eur}
{literal} 
onClick="WdatePicker({dateFmt:'dd/MM/yy HH:mm:ss'})"
{/literal}
{else}
{literal} 
onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
{/literal}
{/if}

/>__*__</li> 	
		{if 'delivery.multi_delivery'|C==1}
		<li><input type="checkbox" name="sale_finish" id="sale_finish" value="1" {if $rs.sale_finish==1} checked {/if}>&nbsp;&nbsp;{$lang.sale_finish}</li>
		{else}
		<input type="hidden" name="sale_finish" id="sale_finish" value="1" checked>
		{/if}
		
		</ul>
         </div>
         </td></tr>   
          <tr><th>{$lang.delivery_detail}</th></tr>  
          
          <tr><td>{include file="DeliverySale/detail.tpl"}</td></tr> 
          <tr><td class="pad_top_10">
	          <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr> 
					<td width="12%" valign="top">{$lang.comments}：</td>
					<td class="t_left" width="35%" valign="top"><textarea id="comments" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
					<td width="12%" valign="top">{$lang.receive_addr}：</td>
					<td class="t_left"  valign="top">{$rs.edit_receive_addr}</td>
					</tr>
		</tbody>
		</table>
      </td></tr>                      
   </tbody>          
  </table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 
