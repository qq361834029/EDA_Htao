<form action="{'QuestionOrder/update'|U}" method="POST" name="QuestionOrder_addQuestionOrder">
{wz action="save,list,reset"}
{if $login_user.role_type == C('SELLER_ROLE_TYPE')}
    {assign var="is_warehouse" value=false}
    {assign var="is_factory" value=true}
{elseif $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
    {assign var="is_warehouse" value=true}
    {assign var="is_factory" value=false}
{else}
    {assign var="is_warehouse" value=false}
    {assign var="is_factory" value=false}
{/if}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name='id' id="id" value="{$rs.id}">
<input type="hidden" id="proof_delivery" value="{$rs.dml_proof_delivery_fee}">
<input type="hidden" id="compensation" value="{$rs.dml_compensation_fee}">
</script> 
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>  
    	<tr>
            <th colspan="4">
    			<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    				<div class="afr">{$lang.question_order_no}：{$rs.question_order_no}</div>
    			</div>
    		</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<div class="basic_tb">  
					<ul>
                        <input type="hidden" id="flow" value="QuestionOrder">
                        <input type="hidden" name="add_user" value="{$rs.add_user}">
                        <li>
                            {$lang.belongs_warehouse}： {$rs.w_name}
                        </li>
						<li>
							{$lang.deal_no}：{$rs.sale_order_no}
						</li>
						<li>
							{$lang.orderno}：{$rs.order_no}
						</li>
						<li>
							{$lang.clientname}：{$rs.client_name} 
						</li>
						<li>
							{$lang.express_way}： {$rs.express_name}
						</li>
						<li>
							{$lang.track_no}：{$rs.track_no} 
						</li>
						<li>
							{$lang.order_date}：{$rs.fmd_order_date} 
						</li>
                        <li>{$lang.add_order_date}：
                            {$rs.add_order_date}
                        </li>
                        <li>
                        {$lang.question_reason}：
                        {if !$is_warehouse}
                            {select data=C('QUESTION_REASON') id='question_reason' name='question_reason' empty=true value=$rs.question_reason combobox=1 }__*__
                        {else}
                            {$rs.dd_question_reason}
                        {/if}
                        </li>
                        {if !$is_factory}
                            <li>{$lang.state}：
                                {if $rs.question_order_state != C('PENDING')}
                                    {assign var=filter value=C('PENDING')}
                                {/if}
                                {select data=C('QUESTION_ORDER_STATE') name="question_order_state" id='question_order_state' value=$rs.question_order_state  onchange="getProcessMode();"  combobox='' empty=true initvalue="1" filter=$filter}__*__
                            </li>
                            <li {if $rs.question_order_state <=C('PENDING')}style="display: none;"{/if}>{$lang.treatment}：
                                <input type="hidden" name="process_mode" id="process_mode" onchange="ProcessMode();" value={$rs.process_mode}>
                                <input type="text" id="process_mode_name" name="temp[process_mode_name]" value="{$rs.dd_process_mode}" where="{$rs.question_order_state}" url="{'/AutoComplete/processMode'|U}" jqac>__*__
                            </li>
                            <li style="{if $rs.question_order_state <=C('PENDING')}display: none;{/if}padding-right: 20px;">
                                {$lang.proof_delivery_fee}：
                                <input type="text" id='proof_delivery_fee' name="proof_delivery_fee" value="{$rs.dml_proof_delivery_fee}" {if $rs.process_mode == C('UPLOADED_PROOF')}class="spc_input"{else}class="spc_input disabled" readonly{/if}>{$rs.currency_no}__*__
                            </li>	
                            <li {if $rs.question_order_state <=C('PENDING')}style="display: none;"{/if}>
                                {$lang.compensation_fee}：
                                <input type="text" id='compensation_fee' name="compensation_fee" {if $rs.process_mode == C('HAS_COMPENSATION')}class="spc_input"{else}class="spc_input disabled" readonly{/if} value="{$rs.dml_compensation_fee}">{$rs.currency_no}__*__
                            </li>
                            <li  {if $rs.process_mode !=C('HAS_COMPENSATION')}style="display: none;"{/if}>
                                {$lang.compensation_date}：
                                {if C('digital_format')=='eur'}
                                    <input type="text" name="compensation_date" id="compensation_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$rs.fmd_compensation_date|default:$this_day}"/>__*__
                                {else}
                                    <input type="text" name="compensation_date" id="compensation_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$rs.fmd_compensation_date|default:$this_day}"/>__*__
                                {/if}
                            </li>
                            <li id="compensation_date_show" {if $rs.process_mode ==C('HAS_COMPENSATION') || $rs.compensation_date == 0}style="display: none;"{/if}>
                                {$lang.compensation_date}：
                                {$rs.compensation_date}
                            </li>
                        {else}                            
                            <li>{$lang.state}：
                                {$rs.dd_question_order_state}
                            </li>
                            <li {if $rs.question_order_state<=C('PENDING')}style="display: none;"{/if}>
                                {$lang.treatment}：
                                <input type="hidden" name="question_order_state" value="{$rs.question_order_state}">
                                <input type="hidden" name="process_mode" id="process_mode" value={$rs.process_mode}>
                                {if in_array($rs.process_mode,array(C('PROVIDE_CLIENT_MOBILE'),C('CHECK_CLIENT_INFO'),C('WAIT_FOR_SELLOR_TO_DEAL')))}                                    
                                    <input type="text" id="process_mode_name" name="temp[process_mode_name]" value="{$rs.dd_process_mode}"  url="{'/AutoComplete/sellerProcessMode'|U}" jqac>__*__                                   
                                {else}     
                                     {$rs.dd_process_mode}
                                {/if}
                            </li>
                            <li {if $rs.process_mode<C('UPLOADED_PROOF')}style="display: none;"{/if}>
                                {$lang.proof_delivery_fee}：
                                {$rs.dml_proof_delivery_fee}
                            </li>
                            <li {if $rs.process_mode<C('HAS_COMPENSATION')}style="display: none;"{/if}>
                                {$lang.compensation_fee}：
                                {$rs.dml_compensation_fee}
                            </li>
                            <li {if $rs.process_mode<C('HAS_COMPENSATION')}style="display: none;"{/if}>
                                {$lang.compensation_date}：
                                {$rs.compensation_date}
                            </li>
                        {/if}
                        <li {if $rs.process_mode!=C('FINISH')}style="display:none"{/if}>
						{$lang.finish_date}：
						{if C('digital_format')=='eur'}
							<input type="text" name="finish_date" id="finish_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$rs.finish_date|default:$smarty.now|date_format:'%d/%m/%y'}"/>__*__
						{else}
							<input type="text" name="finish_date" id="finish_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$rs.finish_date|default:$smarty.now|date_format:'%Y-%m-%d'}"/>__*__	
						{/if}
						</li>
						<li {if !in_array($rs.process_mode, array(C('PROVIDE_CLIENT_MOBILE'), C('PENDING_WAREHOUSE')))}style="display:none"{/if}>
						{$lang.tel}：
							<input type="text" name="mobile" org_value="{$rs.mobile}" {if $rs.process_mode != C('PROVIDE_CLIENT_MOBILE')}readonly="true" class="spc_input disabled"{/if} value="{$rs.mobile}" id="mobile" class="spc_input">{if $is_factory}__*__{/if}
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
                {include file="Public/client_info_view.tpl"}
			</td>
    	</tr> 
		<tr><th>{$lang.other_info}</th></tr>  
    	<tr>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top" class="t_right" width="20%">{$lang.comments}：</td>
							<td class="t_left" valign="top" width="80%"  style="line-height: 15px;">
								{$rs.comments}
							</td>    
						</tr>
                        <tr>
                            <td valign="top" class="t_right" width="20%">{$lang.factory_comments}：</td>
                            <td class="t_left" valign="top" width="80%">
                                <textarea id="factory_comments" name="factory_comments" {if $is_factory}class="textarea_height80"{else}class="textarea_height80 disabled" readonly{/if}>{$rs.edit_factory_comments}</textarea>
                            </td>    
                        </tr>
                        <tr>
                            <td valign="top" class="t_right" width="20%">{$lang.warehouse_comments}：</td>
                            <td class="t_left" valign="top" width="80%">
                                <textarea id="warehouse_comments" name="warehouse_comments" {if $is_warehouse}class="textarea_height80"{else}class="textarea_height80 disabled" readonly{/if}>{$rs.edit_warehouse_comments}</textarea>
                            </td>    
                        </tr>
                        {if !$is_warehouse}
                            <tr id='question_pics'>
                                <td>{$lang.upload_question_pics}：</td>
                                <td class="t_left">
                                    {upload tocken=$file_tocken multi=true sid=$sid type=23}
                                </td>
                            </tr>
                        {/if}
                        {if $rs.question_pics}
                            <tr id="question_pics_show">
                                <td>{$lang.question_pics}：</td>
                                <td class="t_left">
                                    {showFiles from=$rs.question_pics  delete=!$is_warehouse}
                                </td>
                            </tr>
                        {/if}
                        
                        {if !$is_factory}
                            <tr id='transaction_proof'{if $rs.process_mode<C('UPLOADED_PROOF')}style="display: none;"{/if}>
                                <td>{$lang.upload_transaction_proof}：</td>
                                <td class="t_left">
                                    {upload tocken=$file_tocken multi=true sid=$fid type=24 allowTypes="all"}
                                </td>
                            </tr>
                        {/if}
                        
                        <tr id='transaction_proof_show'>
                            {if $rs.transaction_proof}
                            <td>{$lang.transaction_proof}：</td>
                            <td class="t_left">
                                {foreach $rs.transaction_proof as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                        {if !$is_factory}
                                        <a onclick="$.deleteFile({$val.id})" href="javascript:;">
                                            <img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
                                        </a>
                                        {/if}
                                    </div>
                                {/foreach}
                            <td>
                            {/if}
                        </tr>
                        {if !$is_warehouse}
                            <tr id='invoice_file'{if $rs.process_mode<C('UPLOAD_INVOICES')}style="display: none;"{/if}>
                                <td>{$lang.upload_invoice_file}：</td>
                                <td class="t_left">
                                    {upload tocken=$file_tocken multi=true sid=$fid type=25 allowTypes="all"}
                                </td>
                            </tr>
                        {/if}
                        
                        <tr id='invoice_file_show'>
                            {if $rs.invoice_file}
                            <td>{$lang.invoice_file_show}：</td>
                            <td class="t_left">
                                {foreach $rs.invoice_file as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                        {if !$is_warehouse}
                                        <a onclick="$.deleteFile({$val.id})" href="javascript:;">
                                            <img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
                                        </a>
                                        {/if}
                                    </div>
                                {/foreach}
                            <td>
                            {/if}
                        </tr>
					</tbody>
				</table>
			</td>
    	</tr>
 	</tbody>
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>