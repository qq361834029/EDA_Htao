{wz is_update=$rs.is_update}
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
							{$lang.clientname}： {$rs.client_name}
						</li>
						<li>
							{$lang.express_way}： {$rs.express_name}
						</li>
						<li>
							{$lang.track_no}：{$rs.track_no}
						</li>
						<li>
							{$lang.order_date}： {$rs.fmd_order_date}
						</li>
						<li>
							{$lang.add_order_date}：{$rs.fmd_add_order_date} 
						</li>
                        <li>
                            {$lang.question_reason}：{$rs.dd_question_reason}
                        </li>
						<li>
							{$lang.state}：{$rs.dd_question_order_state}
						</li> 
                        <li>
                            {$lang.treatment}：{$rs.dd_process_mode}
                        </li>
                        {if ($rs.process_mode != 5 || $rs.question_order_state != 20)&&!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))}
                        <li>
                            {$lang.proof_delivery_fee}：{$rs.dml_proof_delivery_fee}{$rs.currency_no}
                        </li>
                        <li>
                            {$lang.compensation_fee}：{$rs.dml_compensation_fee}{$rs.currency_no}
                        </li>
                        {/if}
                        {if $rs.compensation_date > 0}
                            <li>
                                {$lang.compensation_date}：
                                {$rs.compensation_date}
                            </li>
                        {/if}
                        {if $rs.finish_date > 0}
                            <li>
                                {$lang.finish_date}：
                                {$rs.finish_date}
                            </li>
                        {/if}
                        {if $rs.process_mode==C('PROVIDE_CLIENT_MOBILE')}
                        	<li>
                        		{$lang.tel}：
                        		{$rs.mobile}
                        	</li>
                        {/if}
                        </div>
					</ul>
				</div>
			</td>
		</tr>
    	<tr>
    		<th colspan="4">{$lang.question_order_detail}</th>
    	</tr>
    	<tr>
    		<td colspan="4" class="t_center" id="question_order_detail">
                {include file="QuestionOrder/question_detail.tpl"}
    		</td>
    	</tr>  
	<tr><th>{$lang.client_info}</th></tr>  
	<tr>
		<td>
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
						<td class="t_left" valign="top" width="80%" style="line-height: 15px;">
							{$rs.comments}
						</td>    
					</tr>
                    <tr>
                        <td valign="top" class="t_right" width="20%">{$lang.warehouse_comments}：</td>
                        <td class="t_left" valign="top" width="80%" style="line-height: 15px;">
                            {$rs.warehouse_comments}
                        </td>    
                    </tr>
                    <tr>
                        <td valign="top" class="t_right" width="20%">{$lang.factory_comments}：</td>
                        <td class="t_left" valign="top" width="80%" style="line-height: 15px;">
                            {$rs.factory_comments}
                        </td>    
                    </tr>
                    {if $rs.question_pics}
                        <tr>
                            <td>{$lang.question_pics}：</td>
                            <td class="t_left">{showFiles from=$rs.question_pics}
                            </td>
                        </tr>
                    {/if}
                    {if $rs.transaction_proof}
                        <tr>
                            <td>{$lang.transaction_proof}：</td>
                            <td class="t_left">
                                {foreach $rs.transaction_proof as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                    </div>
                                {/foreach}
                            <td>
                        </tr>
                    {/if}
                    {if $rs.invoice_file}
                        <tr>
                            <td>{$lang.invoice_file_show}：</td>
                            <td class="t_left">
                                {foreach $rs.invoice_file as $val}
                                    <div id="file_view_{$val.id}">
                                        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                                    </div>
                                {/foreach}
                            <td>
                        </tr>
                    {/if}
				</tbody>
			</table>
		</td>
    	</tr> 
 	</tbody>
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>