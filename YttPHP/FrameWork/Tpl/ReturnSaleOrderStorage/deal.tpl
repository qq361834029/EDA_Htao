<form action="{'ReturnSaleOrderStorage/updateDeal'|U}" method="POST" name="ReturnSale_addReturnOrder">
{wz action="list,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name='id' value="{$rs.id}">
<input type="hidden" name='return_sale_order_id' value="{$rs.return_sale_order_id}">
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
                            <li>
                                {$lang.storage_abnormal}：
                                {$rs.dd_storage_abnormal}
                                <input type="hidden" name="storage_abnormal" id="storage_abnormal" value="{$rs.storage_abnormal}">
                            </li>
                            <div style="float: left">
                                <li>
                                {$lang.return_logistics_no}：
                                {$rs.return_logistics_no}
                                </li>
                            </div>  
                            <li {if !$rs.storage_abnormal}style="display: none"{/if}>
                                {$lang.storage_abnormal_reason}：
                                {$rs.dd_storage_abnormal_reason}
                                <input type="hidden" name="storage_abnormal_reason" id="storage_abnormal_reason" value="{$rs.storage_abnormal_reason}">
                            </li>
                            <li>
                                {$lang.is_hand}：
                                {radio data=C('YES_NO') name='is_hand' id='is_hand' value=$rs.is_hand}
                            </li>
                            <div style="clear: both"></div>
                            <div style="float: left">
                            <li>
                                {$lang.is_outer_pack_condition}：
                                <input type="hidden" id="outer_pack" name="outer_pack" value="{$rs.outer_pack}">
                                {$rs.dd_outer_pack}
                            </li>
                            <li {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}style="margin: 0 25px 0 75px;"{/if}>
                                <div {if $rs.outer_pack!=2}style="display: none;"{/if}>
                                {$lang.outer_package}：
                                <input type="hidden" id="outer_pack_id" name="outer_pack_id" value="{$rs.outer_pack_id}">
                                {$rs.outer_pack_name}
                                </div>
                            </li>                   
                            <li>
                                <div {if $rs.outer_pack!=2}style="display: none;"{/if}>
                                {$lang.outer_pack_quantity}：
                                <input type="hidden" id="outer_pack_quantity" name="outer_pack_quantity"  value="{$rs.outer_pack_quantity}" class="spc_input" />
                                {$rs.outer_pack_quantity}
                                </div>
                            </li>
                            </div>
                            <div style="float: left">
                            <li>
                                {$lang.is_within_pack_condition}：
                                <input type="hidden" id="within_pack" name="within_pack" value="{$rs.within_pack}">
                                {$rs.dd_within_pack}
                            </li>  
                            <li {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}style="margin: 0 25px 0 75px;"{/if}>
                                <div {if $rs.within_pack!=2}style="display: none;"{/if}>
                                {$lang.within_package}：
                                <input type="hidden" id="within_pack_id" name="within_pack_id" value="{$rs.within_pack_id}">
                                {$rs.within_pack_name}
                                </div>
                            </li> 
                            <li>
                                <div {if $rs.within_pack!=2}style="display: none;"{/if}>
                                {$lang.within_pack_quantity}：
                                <input type="hidden" id="within_pack_quantity" name="within_pack_quantity" value="{$rs.within_pack_quantity}" class="spc_input"/>
                                {$rs.within_pack_quantity}
                                </div>
                            </li> 
                            </div>
					</ul>
				</div>
			</td>
		</tr>
    	<tr>
    		<th  colspan="4">{$lang.return_sale_order_detail}</th>
    	</tr>
    	<tr>
		<td colspan="4" class="t_center" id="return_order_detail">
                {include file="ReturnSaleOrderStorage/deal_return_detail.tpl"}
		</td>
    	</tr> 
    	{if $rs.is_picture}
    	<tr>
			<td>{$lang.upload_file}：</td>
			<td class="t_left">{upload tocken=$file_tocken sid=$sid type=27}</td>
		</tr> 
		{if $rs.pics}
        <tr>
            <td>{$lang.photo}：</td>
            <td class="t_left">{showFiles from=$rs.pics delete=true}
            </td>
        </tr>
        {/if}
        {/if}
 	</tbody>
</table>
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>