{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>  
    	<tr>
    		<th colspan="4">{$lang.basic_info}</th>
    		<div class="afr">{$lang.return_sale_order_no}：{$rs.return_sale_order_no}</div>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<div class="basic_tb">  
					<ul> 
						<input type="hidden" name='is_related_sale_order' value="{$rs.is_related_sale_order}">
						<input type="hidden" name='sale_order_no' value="{$rs.sale_order_no}">
						<input type="hidden" name="sale_order_id" id='sale_order_id' value="{$rs.sale_order_id}">
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
							{$lang.clientname}：{$rs.client_name} 
						</li>
						<li>
							{$lang.track_no}：{$rs.track_no} 
						</li>
						<li>
							{$lang.order_date}：{$rs.fmd_order_date} 
						</li>  
						<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}">
						{else}
						{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
						<li>
							{$lang.belongs_warehouse}： 
							<input type="hidden" name="warehouse_id" id="warehouse_id" value="{$rs.warehouse_id}"/>
							{if $rs.return_sale_order_state != C('RETURN_SALE_ORDER_STATE_PENDING')}
								{$rs.w_name}
							{else}
							<input type="text" id="warehouse_name" name="temp[warehouse_name]" value="{$rs.w_name}" class="spc_input" url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__							
							{/if}
						</li>
						{else}
							<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}">
						{/if}							
						<li>
							{$lang.clientname}： 
							{$rs.client_name}
						</li>
						{/if}
						{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
							<li>{$lang.return_sale_date}：
                                {$rs.fmd_return_order_date}
							</li>
							<li>{$lang.return_sale_order_state}：{$rs.return_sale_order_state}
                            </li> 
						{else} 
							<li>
								{$lang.return_sale_date}： {$rs.fmd_return_order_date}
                            </li>
							<li>
                                {if $rs.return_sale_order_state != 2}
                                    {assign var=filter value='2'}
                                {else}
                                    {assign var=filter value=''}
                                {/if}
								{$lang.return_sale_order_state}：
                                {$rs.dd_return_sale_order_state}
                            </li>
							<li>{$lang.comment}：{$rs.comments}
							</li>  
						{/if}	
							{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
							<li>
								{$lang.return_reason}：
                                {$rs.dd_return_reason}
                            </li>					
							{/if}							
                            <li>
                                {$lang.return_track_no}：
                                {$rs.return_track_no}
                            </li>
                            {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                            <div style="float: left">
                            <li>
                                {$lang.is_outer_pack_condition}：
                                {$rs.dd_outer_pack}
                            </li>
                             <li {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}style="margin: 0 25px 0 155px;"{/if}>
                                {$lang.outer_package}：
                                {$rs.outer_pack_name}
                            </li>
                            <li>
                                {$lang.outer_pack_quantity}：
                                {$rs.outer_pack_quantity}
                            </li>
                            </div>
                            <div style="float: left">
                            <li>
                                {$lang.is_within_pack_condition}：
                                {$rs.dd_within_pack}
                            </li>
                             <li {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}style="margin: 0 25px 0 155px;"{/if}>
                                {$lang.within_package}：
                                {$rs.within_pack_name}
                            </li>
                            <li>
                                {$lang.within_pack_quantity}：
                                {$rs.within_pack_quantity}
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
                {include file="ReturnSaleOrderStorage/shelves_return_detail.tpl"}
		</td>
    	</tr>  
 	</tbody>
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>