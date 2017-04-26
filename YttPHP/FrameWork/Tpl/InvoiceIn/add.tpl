<form action="{"InvoiceIn/insert"|U}" method="POST">
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
    					<li>{$lang.supplier}：
    						{if C('invoice.factory_from')=='1'}
				    			<input type="hidden" name="factory_id" id="factory_id" onchange="getIVA(this,'factory_from');importData();" value="{$rs.factory_id}">
				    			<input type="text" name="supplier_name" url="{'AutoComplete/factory'|U}" jqac value="{$rs.factory_name}" {if $rs}where="{"id in (`$rs.fac_where`)"|urlencode}"{/if}/>
				    			{else}  
				    			<input type="hidden" name="factory_id" id="factory_id" onchange="getIVA(this,'factory_from');importData();" >
				    			<input type="text" name="supplier_name" url="{'AutoComplete/invoiceFactory'|U}" jqac />
				    			{/if}
				    			__*__ 
    					</li>
    					<li>
	    					IVA：
	    					<input type="text" name="iva"  id="iva"  class="spc_input" onchange="" row_tax value="{$rs.factory_iva}">__*__
    					</li>
    					<li>
    						{$lang.invoice_date}：
    						<input type="text" name="invoice_date"  id="invoice_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__		
    					</li>
    					{if 'invoice.import'|C==1}
    					<li>
    						{$lang.instock_no}：
    						{if $rs}
	    					<input type="hidden" name="relation_id" id="relation_id" value="{$rs.id}">
	    					<input type="hidden" name="relation_no"  value="{$rs.instock_no}"/>
	    					<input type="hidden" name="import_type" value="instock" id="import_type">
	    					{$rs.instock_no} 
	    					{else}
	    						<input type="hidden" name="relation_id" id="relation_id" value="{$rs.id}">
	    						<input type="text" name="relation_no" url="{'AutoComplete/invoiceInstockNo'|U}" jqac />
	    						<input type="hidden" name="import_type" value="instock" id="import_type">  
	    						<input type="button" name="importIn" value="{$lang.import}" onclick="importData()" class="button_new">	
	    					{/if}
    					</li>
    					{/if}
    					<li>
    						{$lang.pay_type}：
    						{select data=C('PAID_TYPE') name="paid_type" value=1 onchange="displayCheckNo()" combobox='' empty=true}
    					</li>
    					<li id="check_td_1" style="display:none">
    						<span id="check_td_1" style="display:none">{$lang.check_no}：</span>
    						<span id="check_td_2"  style="display:none"><input type="text" name="check_no"   class="spc_input" >__*__</span>
    					</li>
    					{invoiceCompany type='li' title=$lang.basic_name  hidden=['name'=>'basic_id'] require="" name="basic_name"}
    					{if 'invoiceIn.invoice_no'|C==2}
    					<li>
    						{$lang.invoice_no}：
    						<input type="text" name="invoice_no" value=""  class="spc_input">__*__
    					</li>
    					{/if}
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