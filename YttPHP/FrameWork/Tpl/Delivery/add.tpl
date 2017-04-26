<form action="{'Delivery/insert'|U}" method="POST" onsubmit="return false">
{if $rs.detail}   
{wz action="list,reset"}
{/if}   
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
         <tr><th>{$lang.delivery_basic}</th></tr>
         <tr><td>
         <div class="basic_tb">
          <ul> 
			<input type="hidden" name="sale_date" id="sale_date" value="{$rs.fmd_sale_date}">
			<input type="hidden" name="orders_no" id="orders_no" value="{$rs.orders_no}">	
			<input type="hidden" name="basic_id" id="basic_id" value="{$rs.basic_id}">
			<input type="hidden" name="currency_id" id="currency_id" value="{$rs.currency_id}">
			<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}">
			<input type="hidden" name="sale_order_id" id="sale_order_id" value="{$rs.sale_order_id}">
		<li>{$lang.client_name}：{$rs.client_name}</li>
		<li>{$lang.sale_no}：{$rs.orders_no}</li>
		<li>{$lang.currency}：{$rs.currency_no}</li>
		</ul>
		<ul>
		<li>{$lang.moblie_phone}：<input type="text" name="mobile" id="mobile" value="{$rs.mobile}" class="spc_input"></li>
		<li>{$lang.delivery_date}：<input type="text" name="delivery_date"  value="{$this_time}" id="delivery_date" value="" class="Wdate spc_input" 

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
		<li><input type="checkbox" name="sale_finish" id="sale_finish" value="1" checked>&nbsp;&nbsp;{$lang.sale_finish}</li> 
		{else}
		<input type="hidden" name="sale_finish" id="sale_finish" value="1" checked>
		{/if}
		</ul>
         </div>
         </td></tr>   
          <tr><th>{$lang.delivery_detail}</th></tr> 
          
          {if $rs.detail}   
          <tr><td>{include file="Delivery/detail.tpl"}</td></tr>
          {else}   
          <tr><td>{$lang.delivery_finished_tip}</td></tr>  
          {/if} 
          <tr><td class="pad_top_10">
	          <table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr> 
					<td width="12%" valign="top">{$lang.comments}：</td>
					<td class="t_left" width="35%" valign="top"><textarea id="comments" class="textarea_height80" name="comments"></textarea></td>
					<td width="12%" valign="top">{$lang.receive_addr}：</td>
					<td class="t_left" valign="top">{$rs.receive_addr}</td>
					</tr>
		</tbody>
		</table>
      </td></tr>                      
   </tbody>          
  </table>
</div>
{staff}
</form> 
