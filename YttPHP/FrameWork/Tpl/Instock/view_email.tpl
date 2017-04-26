<form action="{'Instock/insert'|U}" method="POST" >
<input type="hidden" name="logistics_norms" id="logistics_norms" value="<!--{C("FUND_LOGISTICS_NORMS")}-->">

<div style="border: 1px solid #89A5C5;padding:5px 10px 10px 10px;margin:0 auto;height:auto;font-size:12px;">
<input type="hidden" name="load_container_id" value="{$rs.load_container_id}">
<table cellspacing="0" cellpadding="0" style="font-size:12px;line-height:30px;" width="99%">
	<tbody>
		<tr>
			<th style="border-bottom:#ccc 1px dashed;font-weight:bold; color:#366599;text-align:left;">
				<div style="width:100%; float:left; height:30px; line-height:30px;">
    				<div style="float:left;width:35%;text-indent:8px;font-size:14px;text-align:left;">{$lang.title_1}</div>
    				<div style="float:right;color:#ff0000; width:400px;text-align:right; padding-right:5px;font-weight:normal;font-size:12px;padding-right:28px;">{$lang.instock_no}：{$rs.instock_no}</div>
    			</div>
			</th>
		</tr>
		<tr>
			<td >
				<div style="float:left;line-height:28px;width:94%;padding:10px 40px;">  
					<ul> 
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.container_no}：{$rs.container_no}
      					</li>
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.trans_comp}：{$rs.logistics_name}
     					</li> 
     					{if $rs.id>0}
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.load_date}：{$rs.fmd_get_date}
      					</li>
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.delivery_date}：{$rs.fmd_go_date}
      					</li>
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.arrive_date}：
      							{$rs.fmd_arrive_date}
      					</li>
      					{/if}
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.real_arrive_date}：
						{$rs.fmd_real_arrive_date}
						</li>    
						
						{if C('instock.instock_logistics_funds')==1}
						<!--{*超管 入库显示运费 *}-->
						<li style="float:left; width:280px;height:28px;line-height:28px;padding-right:5px;text-align:left;list-style:none;">{$lang.trans_price}：{$rs.dml_delivery_fee}</li>
						{currency data=C('LOGISTICS_CURRENCY') name="currency_id" value=$rs.currency_id title=$lang.trans_price_currency type='li' view=true}
						{/if}
						
						{warehouse type="li" title=$lang.warehouse hidden=["name"=>"warehouse_id","value"=>$rs.warehouse_id]  name="warehouse_name" view=true value=$rs.w_name}
					</ul>
				</div>  	
  			</td>
  		</tr> 
    	<tr><th style="border-bottom:#ccc 1px dashed;padding-left:8px;font-weight:bold;color:#366599;text-align:left;font-size:14px;">{$lang.title_2}</th></tr>
       <tr><td height="8"></td></tr> 	
    	<tr>
    		<td style="text-align:center;">
    		{if $rs.id>0}
    			{include file="Instock/flow_detail_email.tpl"}
    		{else}
    			{include file="Instock/detail_email.tpl"}
    		{/if}
    		</td>
    	</tr>
    	<tr>
    		<td style="padding-top:10px;">
    			<table cellspacing="0" cellpadding="0" width="100%" style="line-height:30px;font-size:12px;">
    				<tr>
	   					<td valign="top" width="20%" style="text-align:right!important;">{$lang.comments}：</td>
	   					<td colspan="3" style="text-align:left!important;" valign="top" width="80%" >{$rs.edit_comments} </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	    
    </tbody>
</table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>