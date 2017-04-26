<form action="{'Picking/insert'|U}" method="POST" onsubmit="return false;">
{wz action="save,list,reset"}
<input type="hidden" name="tocken" value="{$file_tocken}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>
		<tr>
			<td colspan="4">
				<div class="basic_tb">  
					<ul> 
						<li>{$lang.warehouse_name}：
							<input type="hidden" id="warehouse_id" onchange="filterPickingSaleOrderNO();filterExpressWay();getExpressCompany(this);" name="warehouse_id" value="{$w_id}" />
                            <input url="{'AutoComplete/saleWarehouse'|U}" value="{$w_name}" {if $w_id > 0}disabled="disabled" class="spc_input disabled"{else}class="spc_input" jqac{/if} />__*__
						</li>
                        <li>{$lang.express}：
                            <input type="hidden" name="company_id" id="company_id"  onchange="controlPick();" >
                            <input type="text" name="company_name" id="company_name" url="{'/AutoComplete/companyUse'|U}" where="1" jqac/>
                        </li>
                        <li>{$lang.express_way}：						 
						    <input type="hidden" onchange="controlPick();"  name="express_id" id="express_id">
						    <input id="express_name" name="express_way" url="{'/AutoComplete/shippingName'|U}" where="" jqac>						 								 						
						</li>                        
						<li>{$lang.factory_name}：
								<input type="hidden" onchange="filterPickingSaleOrderNO();" name="sale[query][factory_id]" id="factory_id">
								<input id="factory_name" url="{'/AutoComplete/factoryEmail'|U}" jqac>							
						</li>
						<li>{$lang.out_stock_type}：
								{select data=C('ORDER_OUT_STOCK_TYPE') name="sale[query][out_stock_type]" onchange="filterPickingSaleOrderNO();" id="out_stock_type" combobox=1}							
						</li>
                        <li>{$lang.is_warehouse_pickup}：

                            <input id="is_warehouse_pickup" type="checkbox" name="sale[is_warehouse_pickup]" onclick="isWareHousePickUp();" />
						</li>
                        <li style="display: none;">{$lang.deal_no}：

                            <input type="text" id="sale_order_no" value="{$smarty.post.sale.query.sale_order_no}" name="sale[query][sale_order_no]" url="{'AutoComplete/saleDealNoExpress'|U}" where="{" b.company_id = '{C('ONESELF_TAKE')}' and a.sale_order_state ='{C('SALE_ORDER_STATE_EXPORTING')}'"|urlencode}" init_where="{" b.company_id = '{C('ONESELF_TAKE')}' and a.sale_order_state ='{C('SALE_ORDER_STATE_EXPORTING')}'"|urlencode}" jqac />

                        </li>
                        <li>{$lang.order_type}：
                            <input type="hidden" id="order_type" name="sale[query][order_type]" value="" />
                            <input url="{'AutoComplete/orderTypeTag'|U}" value="" class="spc_input" jqac/>
						</li>
                        <li>{$lang.doc_date}：
							{if 'digital_format'|C==eur}
								{assign var='dateFmt' value='dd/MM/yy HH:mm:ss'}
							{else}
								{assign var='dateFmt' value='yyyy-MM-dd HH:mm:ss'}
							{/if}
                            <input type="text" id='date_from' name="sale[date][s.from_create_time]" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'{$dateFmt}' })" />
							&nbsp;&nbsp;{$lang.to_date}&nbsp;&nbsp;
							<input type="text" id='date_to' name="sale[date][s.to_create_time]" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'{$dateFmt}' })" />
						</li>
					</ul>
				</div>
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4">{$lang.detail_info}</th>
		</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	 		
    </tbody>
</table>
{staff}
</div>
</form>
