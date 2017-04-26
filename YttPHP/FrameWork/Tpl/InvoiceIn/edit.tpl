<form action="{"InvoiceIn/update"|U}" method="POST">
{wz action='save,reset'}
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
    						
	    					<input type="hidden" name="invoice_no" value="{$rs.invoice_no}"  class="spc_input">
	    					
    						<li>{$lang.supplier}：
    							{if C('invoice.factory_from')=='1'}
				    			<input type="hidden" name="factory_id" id="factory_id" onchange="{if C('product_factory')==1&&C('product_from')==1}$.productEnabled(this);{else}$.invoiceProductEnabled(this);{/if}getIVA(this,'factory_from');" value="{$rs.factory_id}">
				    			
				    			{else}  
				    			<input type="hidden" name="factory_id" id="factory_id" onchange="getIVA(this,'factory_from')" value="{$rs.factory_id}">
				    			
				    			{/if}
				    			{$rs.factory_name}
    						</li>
    						<li>IVA：<input type="text" name="iva"  id="iva"  class="spc_input" value="{$rs.edml_iva}" row_tax>__*__	</li>
    						<li>{$lang.invoice_date}：<input type="text" name="invoice_date"  id="invoice_date" value="{$rs.fmd_invoice_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	</li>
    						{if C('invoice.product_from')==1&&$rs.relation_id>0}
	    					<li>{$lang.instock_no}：
	    						{$rs.relation_no}
	    					</li>
	    					{/if} 
	    					<li>
	    						{$lang.pay_type}：{select data=C('PAID_TYPE') name="paid_type" value=$rs.paid_type onchange="displayCheckNo()" combobox='' empty=true}
	    					</li>
	    					<li {if $rs.paid_type!=2}style="display:none"{/if} id="check_td_1">
	    						{$lang.check_no}：
	    						<input type="text" name="check_no"   class="spc_input" value="{$rs.check_no}" >__*__
	    					</li>
	    					{invoiceCompany type='li' title=$lang.basic_name  hidden=['name'=>'basic_id','value'=>$rs.basic_id] require="" name="basic_name" value=$rs.basic_name}
	    					
    					</ul>
    				</div>
    				<input type="hidden" name="relation_id" id="relation_id" value="{$rs.relation_id}">
    				<input type="hidden" name="relation_no" value="{$rs.relation_no}" />
    				<input type="hidden" name="import_type" value="instock" id="import_type">  			
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
    		 	<td colspan="4" class="pad_top_10">
    				<table cellspacing="0" cellpadding="0" width="100%">		
    					<tr>
    						<td valign="top">{$lang.comments}：</td>
    						<td  class="t_left" valign="top">
    							<textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea>
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
</form>