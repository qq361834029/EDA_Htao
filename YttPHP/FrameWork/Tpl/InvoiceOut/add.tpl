<form action="{"InvoiceOut/insert"|U}" method="POST">
{if $rs}
{wz action='list,reset'}
{else}
{wz action='save,list,reset'}
{/if}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
	<tbody>  
    		<tr>
    			<th colspan="4">{$lang.basic_info}</th>
    		</tr>
    		<tr>
    			<td colspan="4">
    				<div class="basic_tb">
    					<ul>
    						<li>{$lang.client_name}：
    							{if C('invoice.client_from')=='1'}
				    			<input type="hidden" name="client_id" id="client_id" onchange="getIVA(this,'client_from');" value="{$rs.client_id}">
				    			<input type="text" name="client_name" url="{'AutoComplete/client'|U}" jqac value="{$rs.client_name}"/>
				    			{else}  
				    			<input type="hidden" name="client_id" id="client_id" onchange="getIVA(this,'client_from')" value="{$rs.client_id}">
				    			<input type="text" name="client_name" url="{'AutoComplete/invoiceClient'|U}" jqac value="{$rs.client_name}"/>
				    			{/if}
    							__*__  
    						</li>
    						<li>IVA：<input type="text" name="iva"  id="iva"  class="spc_input" value="{$rs.edml_iva}" row_tax>__*__</li>
    						<li>{$lang.invoice_date}：<input type="text" name="invoice_date"  id="invoice_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
    						</li>
    						{if 'invoiceOut.invoice_no'|C==2}
    						<li><span id="span_invoice_no_lang">{$lang.invoice_no}：</span>
    							<span id="span_invoice_no" class="t_left"><input type="text" name="invoice_no" class="spc_input" ></span>
    						</li>
    						{/if}
    						<li>{$lang.pay_type}：{select data=C('PAID_TYPE') name="paid_type" value=1  onchange="displayCheckNo()" combobox='' empty=true}</li>
    						<li id="check_td_1" style="display:none">
    							{$lang.check_no}：
    							<input type="text" name="check_no"   class="spc_input" >__*__	
    						</li>
    						<li>{$lang.invoice_type}：
    							{if 'invoice.invoice_return_show'|C==2}
	    						<input type="hidden" name="invoice_type" value="1">{$lang.sale}
	    						{else}
	    						{radio data=C('INVOICE_TYPE') name='invoice_type' initvalue=$smarty.get.invoice_type|default:1 onclick='setInvoiceType()'}
	    						{/if}
    						</li>
    						{if 'invoice.import'|C==1}
    						<li class="w320">
    							<span id="lang_order_no">
    								{if $smarty.get.invoice_type==1||$smarty.get.invoice_type==0}
		    							{$lang.sale_no}：
		    						{else}
		    							{$lang.return_sale_order_no}：
		    						{/if}
    							</span>{if $smarty.get.invoice_type==1||$smarty.get.invoice_type==0}
    							<input type="hidden" name="import_type" value="saleorder" id="import_type">
	    						{elseif $smarty.get.invoice_type==2}<input type="hidden" name="import_type" value="return" id="import_type" >{/if}<input type="hidden" name="relation_id" id="relation_id" value="{$rs.id}">
    							<input type="text" name="relation_no"  jqac
								{if $rs.client_id>0&&'invoice.client_from'|C==1} where="{"client_id=`$rs.client_id`"|urlencode}" {/if}
    							{if $rs.client_id>0&&'invoice.client_from'|C==2} where="{"client_id=`$rs.connect_client`"|urlencode}" {/if}
    							{if $smarty.get.invoice_type==1||$smarty.get.invoice_type==0}value="{$rs.sale_order_no}" url="{'AutoComplete/invoiceSaleOrderNo'|U}"{else}value="{$rs.return_sale_order_no}" url="{'AutoComplete/invoiceReturnOrderNo'|U}"{/if}>
    							<input type="button" name="import_in" value="{$lang.import}" class="button_new" onclick="importData()">
    						</li>
    						{/if}
    						{invoiceCompany type='li' title=$lang.basic_name  hidden=['name'=>'basic_id','value'=>$rs.basic_id] require="" name="basic_name" value=$rs.basic_name}
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
    						<td valign="top">{$lang.comments}：</td>
    						<td  class="t_left" valign="top">
    							<textarea name="comments" id="comments" class="textarea_height80"></textarea>
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
{staff}
</div>
</form>