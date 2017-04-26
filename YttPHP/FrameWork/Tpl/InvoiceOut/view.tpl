{wz}

<div class="add_box">
{include file="InvoicePrint/print.tpl"}
</div>
<!-- 
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
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
    						<li>{$lang.client_name}：{$rs.client_name}</li>
    						<li>IVA：{$rs.edml_iva}</li>
    						<li>{$lang.invoice_date}：{$rs.fmd_invoice_date}</li>
    						<li>{$lang.pay_type}：{$rs.dd_paid_type}</li>
    						<li {if $rs.paid_type!=2}style="display:none"{/if}>
    							{$lang.check_no}：{$rs.check_no}
    						</li>
    						<li>{$lang.invoice_type}：{$rs.dd_invoice_type}</li>
    						{if $rs.relation_id>0}
    						<li>
    							{if $rs.invoice_type==1}
	    							{$lang.sale_no}：
	    						{else}
	    							{$lang.return_sale_order_no}：
	    						{/if}
	    						{$rs.relation_no}
    						</li>
    						{/if}
    						{invoiceCompany type='li' title=$lang.basic_name  hidden=['name'=>'basic_id','value'=>$rs.basic_id] require="" view=true name="basic_name" value=$rs.basic_name}
    					</ul>
    				</div>
    			</td>
    		</tr>    		
    		<tr>
    			<th  colspan="4">{$lang.detail_info}</th>
    		</tr>
    		<tr>
    			<td colspan="4" class="t_center">
    				{include file="InvoiceOut/detail.tpl"}
    			</td>
    		</tr>      		
    		
    		 <tr>
    		 	<td colspan="4" class="pad_top_10">
    				<table cellspacing="0" cellpadding="0" width="100%">		
    					<tr>
    						<td valign="top" width="15%">{$lang.comments}：</td>
    						<td  class="t_left">
    							{$rs.comments}
    						</td>
    						<td colspan="2" width="30%">
    							<table class="list">
    								<tr>
    									<td class="t_right tbold" width="40%" bgcolor="#F6F5F5">{$lang.goods_cost}：</td>
    									<td class="t_right tbold red" tax_quantity>{$rs.detail_total.dml_discount_money}</td>
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
</form>
-->