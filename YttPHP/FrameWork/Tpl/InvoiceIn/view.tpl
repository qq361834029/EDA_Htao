{wz}

<div class="add_box">
{include file="InvoicePrint/print.tpl"}
</div>
<!--
{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
	<tbody>
    		<tr>
    			<th colspan="4">
    			<div class="titleth">
	    				<div class="titlefl">{$lang.basic_info}</div>
	    				<div class="afr">{$lang.invoice_no}：{$rs.invoice_no}</div>
	    		</div>
    			</th>
    		</tr>
    		<tr>
    			<td colspan="4">
    				<div class="basic_tb">
    					<ul>
    						<li><label>{$lang.supplier}：</label>{$rs.factory_name}	</li>
    						<li>IVA：{$rs.dml_iva}</li>
    						<li>{$lang.invoice_date}：{$rs.fmd_invoice_date}</li>
    						{if C('invoice.product_from')==1&&$rs.relation_id>0}
    						<li>{$lang.instock_no}：{$rs.relation_no}</li>
    						{/if}
    						<li>{$lang.pay_type}：{$rs.dd_paid_type}</li>
    						{if $rs.paid_type==2} 
    						<li>{$lang.check_no}：{$rs.check_no}</li>
    						{/if}
    						{invoiceCompany type='li' title=$lang.basic_name  hidden=['name'=>'basic_id'] value=$rs.basic_name name="basic_name" view=true}
    					</ul>
    			</td>
    		</tr>    		
    		<tr>
    			<th  colspan="4">{$lang.detail_info}</th>
    		</tr>
    		<tr>
    			<td colspan="4" class="t_center">
    				{include file="InvoiceIn/detail.tpl"}
    			</td>
    		</tr>      		
    		
    		 <tr>
    		 	<td colspan="4"  class="pad_top_10">
    				<table cellspacing="0" cellpadding="0" width="100%">		
    					<tr>
    						<td valign="top" width="15%">{$lang.comments}：</td>
    						<td  class="t_left" valign="top">
    							{$rs.comments}
    						</td> 
    						<td colspan="2" width="30%">
    							<table class="list">
    								<tr>
    									<td class="t_right tbold" width="40%" bgcolor="#F6F5F5">{$lang.goods_cost}：</td>
    									<td class="t_right tbold red" tax_quantity>{$rs.detail_total.dml_money}</td>
    								</tr>
    								<tr>
    									<td class="t_right tbold" bgcolor="#F6F5F5">{$lang.iva_cost}：</td>
    									<td class=" t_right tbold red" tax_cost>{$rs.detail_total.dml_iva_cost}</td>
    								</tr>
    								<tr>
    									<td class="t_right tbold" bgcolor="#F6F5F5">{$lang.total_cost}：</td>
    									<td class="t_right tbold red" tax_total_cost>{$rs.detail_total.dml_total_cost}</td>
    								</tr>
    							</table>
    						</td>    	   			
    					</tr>
    			</table>
			</td>
		</tr>
	</tbody>
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

-->