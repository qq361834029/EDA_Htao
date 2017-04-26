<div style="border: 1px solid #89A5C5;padding:5px 10px 10px 10px;margin:0 auto;height:auto;font-size:12px;">
<table cellspacing="0" cellpadding="0" style="font-size:12px;line-height:30px;" width="99%">
    <tbody> 
         <tr>
    			<th style="border-bottom:#ccc 1px dashed;font-weight:bold; color:#366599;text-align:left;">
    			<div style="width:100%; float:left; height:30px; line-height:30px;">
    				<div style="float:left;width:35%;text-indent:8px;font-size:14px;text-align:left;">{$lang.sale_order_basic}</div>
    				<div style="float:right;color:#ff0000; width:400px;text-align:right; padding-right:5px;font-weight:normal;font-size:12px;padding-right:28px;">{$lang.sale_no}：{$rs.sale_order_no}</div>
    			</div></th>
    		</tr>
         <tr><td>
         <div  style="float:left;line-height:28px;width:94%;padding:10px 40px;">
         <ul>  
			<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.client_name}： {$rs.client_name}</li>
 {company  type="li" title=$lang.basic_name 
hidden=['name'=>'basic_id','id'=>'basic_id']
name='basic_name' value=$rs.basic_name view=true
}
			{currency data=C('CLIENT_CURRENCY') name="currency_id" id="currency_id" value=$rs.currency_id type='li' title=$lang.currency_name require="" view=true}
			<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.sale_date}：{$rs.fmd_order_date}</li>
			{if C('sale.relation_sale_follow_up')==1}
				<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.expect_shipping_date}：{$rs.fmd_expect_shipping_date}</li> 
			{/if}
		 </ul>
         </div>
         </td></tr>   
      <tr><th style="border-bottom:#ccc 1px dashed;padding-left:8px;font-weight:bold;color:#366599;text-align:left;font-size:14px;">{$lang.sale_order_detail}</th></tr>   
           <tr><td height="8"></td></tr> 
          <tr><td>{include file="SaleOrder/detail_email.tpl"}</td></tr>
         
          <tr><td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height:26px;font-size:12px;">
				  <tr>
				    <td style="text-align:right;border-left:1px solid #cccccc;border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;">{$lang.preferential_money}：</td>
				    <td width="125" style="text-align:right;border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;color:#ff0000;font-weight:bold;padding-right:3px;"><span>{$rs.dml_pr_money}</span></td>
				  </tr>
                  {if C('sale.after_preferential_money') == 1}
				    <tr id="sale_funds_after">
				    <td style="text-align:right;border-left:1px solid #cccccc;border-right:1px solid #cccccc;">{$lang.after_preferential_money}：</td>
				    <td style="text-align:right;border-right:1px solid #cccccc;color:#ff0000;font-weight:bold;padding-right:3px;" id="after_preferential_money"><span>{$rs.real_money}<span></td>
				  </tr> 
                  {else}
				    <tr id="sale_funds_after"><td>&nbsp;</td><td>&nbsp;</td></tr>                       
                  {/if}
				  </table> 
				  {include file="Accounts/sale_funds_list_view_email.tpl"}
				  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height:26px;font-size:12px;">
				  <tr id="payadd">
				    <td style="text-align:right;border:1px solid #cccccc;">{$lang.need_get_money1}：</td>
				    <td style="text-align:right;border-right:1px solid #cccccc;border-top:1px solid #cccccc;border-bottom:1px solid #cccccc;color:#ff0000;font-weight:bold;padding-right:3px;" width="125"><span class="t_right_red" id="need_get_money">{$rs.dml_need_paid}</span><input type="hidden" id="old_need_get_money" value="0"></td>
				  </tr> 
				  </table>
				  
				  
          </td></tr>
          <tr><td style="padding-top:10px;">
	          <table width="100%" cellspacing="0" cellpadding="0" border="0" style="line-height:30px;font-size:12px;">
				<tbody>
					<tr>
					<td width="8%" valign="top" style="text-align:right!important;" >{$lang.upload_pic}：</td>
					<td style="text-align:left!important;" valign="top">
						{if $rs.pics}
							{showFiles from=$rs.pics }
						{/if}</td>
					<td width="7%" valign="top" style="text-align:right!important;" >{$lang.receive_addr}：</td>
					<td style="text-align:left!important;" width="25%" valign="top">{$rs.edit_receive_addr}</td>
					<td width="7%" valign="top" style="text-align:right!important;" >{$lang.comments}：</td>
					<td style="text-align:left!important;" width="25%" valign="top">{$rs.edit_comments}</td>
					</tr>
				</tbody>
			 </table>
      </td></tr>                      
   </tbody>          
  </table> 
  {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"} 
  </div>