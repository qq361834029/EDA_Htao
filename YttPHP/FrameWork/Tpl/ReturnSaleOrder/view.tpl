{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>  
    	<tr>
    		<th colspan="4">
    			<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    				<div class="afr">{$lang.return_sale_order_no}：{$rs.return_sale_order_no}</div>
    			</div>
    		</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<div class="basic_tb">  
					<ul> 
						<li>
							{$lang.whether_related_deal_no}：{$rs.dd_is_related_sale_order}
						</li>						
						{if $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER')}
						<li>
							{$lang.deal_no}：{$rs.sale_order_no}
						</li>
						<li>
							{$lang.orderno}：{$rs.order_no}
						</li>
                        <li>
                            {$lang.belongs_warehouse}： {$rs.w_name}
                        </li>
						<li>
							{$lang.clientname}： {$rs.client_name}
						</li>
						<li>
							{$lang.track_no}：{$rs.track_no}
						</li>
						<li>
							{$lang.order_date}： {$rs.fmd_order_date}
						</li>
						{else}
						{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
						<li>
							{$lang.belongs_warehouse}： {$rs.w_name}
						</li>
						{/if}							
						<li>
							{$lang.clientname}： {$rs.client_name}
						</li>
						{/if}
						<li>
							{$lang.return_sale_date}：{$rs.fmd_return_order_date} 
						</li>
						<li>
							{$lang.return_sale_order_state}：{$rs.dd_return_sale_order_state}
						</li> 
                        <li>
                            {$lang.return_reason}：{$rs.dd_return_reason}
                        </li>
                        {if $rs.return_reason==C('RETURN_POSTAGE')&&!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))}
                        <li>
                            {$lang.return_postage_fee}：{$rs.dml_return_postage_fee}{$rs.currency_no}
                        </li>
                        {/if}
                        <li>
							{$lang.return_track_no}：{$rs.return_track_no}
						</li>
                        {if $rs.returned_date>0}
                        <li>
                               {$lang.returned_date}：{$rs.returned_date}
                        </li>
                        {/if}
                        <div style="float: left">
                            <li>
                            {$lang.return_logistics_no}：
                            {$rs.return_logistics_no}
                            </li>
                            <li {if $rs.return_sale_order_state!=C('REFUSE')}style="display:none"{/if}>
                                {$lang.refuse_reason}：
                                {$rs.dd_refuse_reason}
                            </li>
                        </div>  
                        <div style="clear: both"></div>
                        <div style="float: left">
                        <li>
                            {$lang.is_outer_pack_condition}：{$rs.dd_outer_pack}
                        </li>
                        {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                            <li></li>
                        {/if}  
                        <li>
                        {if $rs.outer_pack==2}
                            {$lang.outer_package}：{$rs.outer_pack_name}
                        {/if}
                        </div>
                        <div style="float: left">
                        <li>
                            {$lang.is_within_pack_condition}：{$rs.dd_within_pack}
                        </li>
                        {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                            <li></li>
                        {/if}  
                        <li>
                        {if $rs.within_pack==2}
                            {$lang.within_package}：{$rs.within_pack_name}
                        {/if}
                        </li>
                        </div>
                        {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE') || $login_user.role_type == 1}
                        	<li>{$lang.belongs_seller}：{$rs.factory_name}</li>  
                        {/if}
                        {if $rs.return_process_fee &&!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))}
                           <li id="return_process_fee_li">
                               {$lang.return_process_fee}：{$rs.return_process_fee}{$rs.currency_no}
                           </li>
                        {/if}
					</ul>
				</div>
			</td>
		</tr>
    	<tr>
    		<th colspan="4">{$lang.return_sale_order_detail}</th>
    	</tr>
    	<tr>
    		<td colspan="4" class="t_center" id="return_order_detail">
    		{if in_array($rs.return_sale_order_state,C('VIEW_STORAGE_RETURN_STATE'))&&$login_user.role_type != C('SELLER_ROLE_TYPE')}
                {include file="ReturnSaleOrder/shelves_return_detail.tpl"}
            {else}
                {include file="ReturnSaleOrder/return_detail.tpl"}
            {/if}
    		</td>
    	</tr>  
	<tr><th>{$lang.client_info}</th></tr>  
	<tr>
		<td>
			{include file="Public/client_info_view.tpl"}
		</td>
	</tr> 		
	{if $rs.factory_addition}
	<tr><th>{$lang.factory_info}</th></tr>
	<tr>
		<td>
			{include file="ReturnSaleOrder/factory_info_view.tpl"}
		</td>
	</tr>
	{/if}
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
                        <td valign="top" class="t_right" width="20%">{$lang.comment}：</td>
                        <td class="t_left" valign="top" width="80%" style="line-height: 15px;">
                            {$rs.warehouse_comment}
                        </td>    
                    </tr>
                    {if $rs.pics}
                        <tr>
                            <td>{$lang.pics}：</td>
                            <td class="t_left">{showFiles from=$rs.pics}
                            </td>
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