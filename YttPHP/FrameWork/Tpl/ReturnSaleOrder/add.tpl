<form action="{'ReturnSaleOrder/insert'|U}" method="POST" name="ReturnSale_addReturnOrder">
{wz action="save,list,save_print,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name="check_repeat" id="check_repeat" value="0">
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
                    <input type="hidden" id="flow" value="ReturnSaleOrder">
					<li>
						{$lang.whether_related_deal_no}：
                        <input type="hidden" id="is_related_sale_order" value="1" >
						{radio data=C('WHETHER_RELATED_DEAL_NO') initvalue=C('IS_RELATED_SALE_ORDER') onclick="whetherRelatedDealNo(this, {C('IS_RELATED_SALE_ORDER')});setFacProduct();" name="is_related_sale_order"}
					</li>	
					{if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
						<input type="hidden" name="warehouse_id" id="warehouse_id" value="{$login_user.company_id}">
					{else}
                        <li id="li_warehouse">
                            {$lang.belongs_warehouse}：
                            <input id="warehouse_id" value="" type="hidden" name="warehouse_id" onchange="setSaleOrderWhere();showWCurrency(this,'');" class="valid-required">
                            <input id="warehouse_name" value="" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" where='is_return_sold=1' jqac>__*__
                        </li>						
					{/if}
					{if $login_user.role_type == C('SELLER_ROLE_TYPE')}
						<input type="hidden" name="factory_id" id="factory_id" value="{$login_user.company_id}" onchange="getClientByFactory(this);">
					{else}
					<li id="li_factory" style="display: none;">
						{$lang.belongs_seller}：
						<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}" onchange="getClientByFactory(this);setFacProduct(this);emptyClient()">
						<input type="text" id="factory_name" name="temp[factory_name]" url="{'/AutoComplete/factory'|U}" jqac>__*__
					</li>					
					{/if}					
                    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
					<li id="li_sale_order_no">
						{$lang.deal_no}：
						<input type="hidden" id="sale_order_id" name="sale_order_id" onchange="getSaleOrderInfo(this);">
						<input type="text" id="sale_order_no" name="sale_order_no" url="{'/AutoComplete/saleDealNoShipped'|U}" where="1" style="display: none;" jqac>
                        <input type="text" id='readonly_sale_order_no' class="spc_input disabled" readonly>
                    </li>
                    {else}
                        <li id="li_sale_order_no">
						{$lang.deal_no}：
						<input type="hidden" id="sale_order_id" name="sale_order_id" onchange="getSaleOrderInfo(this);">
						<input type="text" id="sale_order_no" name="sale_order_no" url="{'/AutoComplete/saleDealNoShipped'|U}" where="1" jqac>
                    </li>
                    {/if}
					<li id="li_order_no">
						{$lang.orderno}： 
                        <input type="text" name="order_no" id='order_no' class="spc_input disabled" readonly>
					</li>
					<li id="li_client_name">
						{$lang.clientname}：  
						<input type="hidden" name="client_id" id="client_id" onchange="getClientInfo();" />
						<input type="text" name="client_name" id='client_name' where="factory_id={if $login_user.role_type == C('SELLER_ROLE_TYPE')}{$login_user.company_id}{else}0{/if}" class="spc_input disabled" readonly>
						<span id="quicklyAddClient" style="display: none;">{quicklyAdd module="Client" lang="add_client"}</span>
					</li>					
					<li id="li_track_no">{$lang.track_no}：
						<input type="text" id='track_no' class="spc_input disabled" readonly>
					</li>
					<li id="li_order_date">{$lang.order_date}：
						<input type="text" id="order_date" class="spc_input disabled" readonly/>
					</li> 
					<li>{$lang.return_sale_date}：
					{if C('digital_format')=='eur'}
						<input type="text" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$smarty.now|date_format:'%d/%m/%y'}"/>__*__
					{else}
						<input type="text" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$smarty.now|date_format:'%Y-%m-%d'}"/>__*__	
					{/if}
					</li>
                    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                        {assign var="return_sale_order_state" value=C('ADMIN_RETURN_SALE_ORDER_STATE')}
                    {else}
                        {assign var="return_sale_order_state" value=C('SELLER_RETURN_SALE_ORDER_STATE')}
                    {/if}
					<li>{$lang.return_sale_order_state}：
						{select data=$return_sale_order_state name="return_sale_order_state" id='return_sale_order_state' value=$rs.return_sale_order_state combobox='' empty=true initvalue="9" onchange="getSaleOrderInfo(this);hiddenReturnData(this);refuseReason()" filter='4,7'}__*__
					</li>
                    <li style="display: none;">
                            {$lang.returned_date}：
                        {if C('digital_format')=='eur'}
                            <input type="text" name="returned_date" id="returned_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{time()|date_format:'%d/%m/%y'}"/>__*__
                        {else}
                            <input type="text" name="returned_date" id="returned_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{time()|date_format:'%Y-%m-%d'}"/>__*__	
                        {/if}
                    </li>
					<li>
						{$lang.return_reason}：
						{select data=C('RETURN_REASON') name='return_reason' empty=true combobox=1 onchange="showReturnPostageFee(this)"}__*__
					</li>	
					<li style="display: none">
					   {$lang.return_postage_fee}：
					   <input type="text" name="return_postage_fee" id="return_postage_fee" class="spc_input">
                        <span class="t_left" id="show_w_currency" style="display: none"></span>
					</li>				
                    <li>
                        {$lang.return_track_no}：
						<input type="text" id="return_track_no" name="return_track_no" class="spc_input"/>				 
                    </li>
                    <div style="float: left;">
                        <li>
                            {$lang.return_logistics_no}：
                            <input type="text" name="return_logistics_no" id="return_logistics_no" class="spc_input">
                        </li>
                        <li style="display:none">
                            {$lang.refuse_reason}：
                            {select data=C('REFUSE_REASON') name="refuse_reason" id="refuse_reason" combobox="1" empty=true value="`$rs.refuse_reason`"}__*__
                        </li>
                    </div>
					{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                    <div style="float: left">
                    <li>
                        {$lang.is_outer_pack_condition}：
                        {select data=C('OUTER_PACK') name="outer_pack" id="outer_pack" onchange="setOuterPack(this)" empty=true combobox=1}
                    </li>
                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                            <li></li>
                    {/if}
                    <li>
                        <div style="display: none;">
                        {$lang.outer_package}：
                        <input type="hidden" id="outer_pack_id" name="outer_pack_id" value="">
                        <input type="text" id="outer_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}{$login_user.company_id}{else}0{/if}"  value="" jqac />
                        </div>
                    </li>
                    </div>
                        
                    <div style="float: left">
                    <li>
                        {$lang.is_within_pack_condition}：
                        {select data=C('WITHIN_PACK') name="within_pack" id="within_pack" onchange="setWithinPack(this)" empty=true combobox=1}
                    </li>
                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                            <li></li>
                    {/if}            				
                    <li>
                        <div style="display: none;">
                        {$lang.within_package}：
                        <input type="hidden" id="within_pack_id" name="within_pack_id" value="">
                        <input type="text" id="within_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}{$login_user.company_id}{else}0{/if}"  value="" jqac />
                        </div>
                    </li>
                    </div>
					{/if}	
				</ul>
			</div>
		</td>
	</tr>
    	<tr>
    		<th  colspan="4">{$lang.return_sale_order_detail}</th>
    	</tr>
    	<tr>
		<td colspan="4" class="t_center" id="return_order_detail">
                {include file="ReturnSaleOrder/return_detail.tpl"}
		</td>
    	</tr>  
		<tr><th>{$lang.client_info}</th></tr>  
    	<tr>
			<td id="client_info">
				{include file="Public/client_info.tpl"}
			</td>
    	</tr> 
		<tr><th>{$lang.other_info}</th></tr>  
    	<tr>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top" class="t_right" width="20%">{$lang.comments}：</td>
							<td class="t_left" valign="top" width="80%">
                            {if $login_user.role_type==C('SELLER_ROLE_TYPE')}
                                <textarea id="comments" name="comments" class="textarea_height80"></textarea>
                            {else}
                                <textarea id="comments" name="comments" class="textarea_height80 disabled" readonly></textarea>
                            {/if}
                        </td>    
						</tr>
                        {if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
                            <tr>
                                <td valign="top" class="t_right" width="20%">{$lang.comment}：</td>
                                <td class="t_left" valign="top" width="80%">
                                    <textarea id="warehouse_comment" name="warehouse_comment" class="textarea_height80"></textarea>
                                </td>    
                            </tr>
                        {/if}
                        <tr>
                            <td>{$lang.pics}：</td>
                            <td class="t_left">
                                {upload tocken=$file_tocken sid=$sid type=22 allowTypes="jpg,gif,bmp,png,jpeg,pdf" }
                            </td>
                        </tr> 
					</tbody>
				</table>
			</td>
    	</tr> 		
 	</tbody>
</table>
{staff}
</div>
</form>