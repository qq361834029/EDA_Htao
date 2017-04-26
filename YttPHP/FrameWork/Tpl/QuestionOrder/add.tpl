<form action="{'QuestionOrder/insert'|U}" method="POST" name="QuestionOrder_addQuestionOrder">
{wz action="save,list,reset"}
{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    {assign var="is_factory" value=false}
{else}
    {assign var="is_factory" value=true}
{/if}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
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
                    <input type="hidden" id="flow" value="QuestionOrder">
                    <input type="hidden" id="id" value="{$rs.id}">
                    <input type="hidden" id="proof_delivery" value="{$rs.proof_delivery_fee}">
                    <input type="hidden" id="compensation" value="{$rs.compensation_fee}">
					{if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
						<input type="hidden" name="warehouse_id" id="warehouse_id" value="{$login_user.company_id}">
					{else}
					<li id="li_warehouse">
						{$lang.belongs_warehouse}：
                        <input id="warehouse_id" value="" type="hidden" name="warehouse_id" onchange="setQuestionOrderWhere();showWCurrency(this,'');"  class="valid-required">
                        <input id="warehouse_name" value="" name="warehouse_name_use" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
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
						<input type="hidden" id="sale_order_id" name="sale_order_id" id="sale_order_id" onchange="getQuestionInfo();">
						<input type="text" id="sale_order_no" name="sale_order_no" url="{'/AutoComplete/noQuestionOrder'|U}" where="1" style="display: none;" jqac>
                        <input type="text" id='readonly_sale_order_no' class="spc_input disabled" readonly>
                    </li>
                    {else}
                    <li id="li_sale_order_no">
						{$lang.deal_no}：
						<input type="hidden" id="sale_order_id" name="sale_order_id" id="sale_order_id" onchange="getQuestionInfo();">
						<input type="text" id="sale_order_no" name="sale_order_no" url="{'/AutoComplete/noQuestionOrder'|U}" where="warehouse_id={$login_user.company_id}" jqac>
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
					<li id="li_express_name">
						{$lang.express_way}：
						<input type="hidden" name="express_id" id="express_id" onchange="getClientInfo();"  class="valid-required"/>
						<input type="text"   id='express_name' class="spc_input disabled"  readonly>
					</li>
					<li id="li_track_no">{$lang.track_no}：
						<input type="text" id='track_no' class="spc_input disabled" readonly>
					</li>
					<li id="li_order_date">{$lang.order_date}：
						<input type="text" id="order_date" class="spc_input disabled" readonly/>
					</li>
                    <li>{$lang.add_order_date}：
					{if C('digital_format')=='eur'}
						<input type="text" name="add_order_date" id="add_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$smarty.now|date_format:'%d/%m/%y'}"/>__*__
					{else}
						<input type="text" name="add_order_date" id="add_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$smarty.now|date_format:'%Y-%m-%d'}"/>__*__	
					{/if}
					</li>
                    <li>
						{$lang.question_reason}：
						{select data=C('QUESTION_REASON') id='question_reason' name='question_reason' empty=true combobox=1 }{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}__*__{/if}
					</li>	
                    <li>
                        {$lang.state}：
                        {if $is_factory}
                            <input type="hidden" name="question_order_state" id="question_order_state"  value="{C('UNFINISHED')}">
                            {$lang.unfinished}
                        {else}
                            {select data=C('QUESTION_ORDER_STATE') name="question_order_state" id='question_order_state' value=$rs.question_order_state onchange="getProcessMode();" combobox=''  readonly=$is_factory empty=true initvalue=""  filter='7'}__*__
                        {/if}
                    </li>
                    <li>{$lang.treatment}：
                        {if $is_factory}
                           <input type="hidden" name="process_mode" id="process_mode" value="{C('PENDING_WAREHOUSE')}">
                           {$lang.pending_warehouse}
                        {else}
                            <input type="hidden" name="process_mode" id="process_mode" onchange="ProcessMode();" value="">
                            <input type="text" id="process_mode_name" name="temp[process_mode_name]" where="{$rs.question_order_state}" url="{'/AutoComplete/processMode'|U}" value="" jqac>__*__
                        {/if}
                    </li>
                    
                    <li style="display: none;padding-right: 20px;">
						{$lang.proof_delivery_fee}：
                        <input type="text" id='proof_delivery_fee' name="proof_delivery_fee" class="spc_input disabled" readonly><span class="t_left" id="show_w_currency" style="display: none">{$currency_no}</span>__*__
                    </li>
                    <li style="display: none;">
						{$lang.compensation_fee}：
                        <input type="text" id='compensation_fee' name="compensation_fee" class="spc_input disabled" readonly><span class="t_left" id="show_w_currency" style="display: none">{$currency_no}</span>__*__
                    </li>
                    <li style="display: none;">
                        {$lang.compensation_date}：
					{if C('digital_format')=='eur'}
						<input type="text" name="compensation_date" id="compensation_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$smarty.now|date_format:'%d/%m/%y'}"/>__*__
					{else}
						<input type="text" name="compensation_date" id="compensation_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$smarty.now|date_format:'%Y-%m-%d'}"/>__*__	
					{/if}
					</li>
					<li style="display:none">
					{$lang.finish_date}：
					{if C('digital_format')=='eur'}
						<input type="text" name="finish_date" id="finish_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$smarty.now|date_format:'%d/%m/%y'}"/>__*__
					{else}
						<input type="text" name="finish_date" id="finish_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$smarty.now|date_format:'%Y-%m-%d'}"/>__*__	
					{/if}
					</li>
					<li style="display:none">
					{$lang.tel}：
						<input type="text" name="mobile" id="mobile" class="spc_input readonly" readonly="true">
					</li>
				</ul>
			</div>
		</td>
	</tr>
    	<tr>
    		<th  colspan="4">{$lang.question_order_detail}</th>
    	</tr>
    	<tr>
		<td colspan="4" class="t_center" id="question_order_detail">
                {include file="QuestionOrder/question_detail.tpl"}
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
								<textarea id="comments" name="comments" class="textarea_height80 disabled" readonly></textarea>
							</td>    
						</tr>
                        <tr>
                            <td valign="top" class="t_right" width="20%">{$lang.factory_comments}：</td>
                            <td class="t_left" valign="top" width="80%">
                                <textarea id="factory_comments" name="factory_comments" {if $is_factory}class="textarea_height80"{else}class="textarea_height80 disabled" readonly{/if}></textarea>
                            </td>    
                        </tr>
                        <tr>
                            <td valign="top" class="t_right" width="20%">{$lang.warehouse_comments}：</td>
                            <td class="t_left" valign="top" width="80%">
                                <textarea id="warehouse_comments" name="warehouse_comments" {if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}class="textarea_height80"{else}class="textarea_height80 disabled" readonly{/if}></textarea>
                            </td>    
                        </tr>
                        <tr id='question_pics'>
                            <td>{$lang.question_pics}：</td>
                            <td class="t_left">
                                {upload tocken=$file_tocken multi=true sid=$sid type=23}
                            </td>
                        </tr>
                        <tr id='transaction_proof' style="display: none;">
                            <td>{$lang.transaction_proof}：</td>
                            <td class="t_left">
                                {upload tocken=$file_tocken multi=true sid=$fid type=24 allowTypes="all"}
                            </td>
                        </tr> 
                        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                        <tr id='invoice_file' style="display: none;">
                            <td>{$lang.upload_invoice_file}：</td>
                            <td class="t_left">
                                {upload tocken=$file_tocken multi=true sid=$fid type=25 allowTypes="all"}
                            </td>
                        </tr>
                        {/if}
					</tbody>
				</table>
			</td>
    	</tr> 		
 	</tbody>
</table>
{staff}
</div>
</form>