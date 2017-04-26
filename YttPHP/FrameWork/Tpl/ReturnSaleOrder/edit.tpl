<form action="{'ReturnSaleOrder/update'|U}" method="POST" name="ReturnSale_addReturnOrder">
{wz action="save,list,save_print,reset"}
{*add yyh 20151015 处理完成管理员和仓库可修改退货服务里的金额*}
{if in_array($rs.return_sale_order_state,C('WAREHOUSE_ROLE_CAN_EDIT')) && $login_user.role_type!=C('SELLER_ROLE_TYPE')}
{assign var=finish_processing value=true}
{/if}
{if in_array($rs.return_sale_order_state,C('WAREHOUSE_ROLE_CAN_EDIT')) && $login_user.role_type==C('SELLER_ROLE_TYPE')}
{assign var=pass value=true}
{/if}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name='id' id="id" value="{$rs.id}">
<script type="text/javascript">
    $(function () {
        hiddenAdd();
        refuseReason();
    });
</script> 
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
                        <input type="hidden" id="is_edit_service" value="0">
                        <input type="hidden" id="flow" value="ReturnSaleOrder">
                        <input type="hidden" name="add_user" value="{$rs.add_user}">
                        <input type="hidden" name="return_sale_order_storage_id" value='{$item.return_sale_order_storage_id}'>
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
                            {$lang.belongs_warehouse}： {$rs.w_name}
                        </li>
						<li>
							{$lang.clientname}：{$rs.client_name} 
							<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}"/>
						</li>
						<li>
							{$lang.track_no}：{$rs.track_no} 
						</li>
						<li>
							{$lang.order_date}：{$rs.fmd_order_date} 
						</li>  
						<input type="hidden" name="warehouse_id" id='warehouse_id'  value="{$rs.warehouse_id}">
						{else}
						{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
						<li>
							{$lang.belongs_warehouse}： 
							<input type="hidden" name="warehouse_id" id="warehouse_id"  onchange="setSaleOrderWhere();"  value="{$rs.warehouse_id}"/>
								{$rs.w_name}
						</li>
						{else}
							<input type="hidden" name="warehouse_id" id='warehouse_id' value="{$rs.warehouse_id}">
						{/if}		                        
						<li>
							{$lang.orderno}：
                            {if $rs.return_sale_order_state == C('PROCESS_COMPLETE')}
                                {$rs.order_no}
                                <input type="hidden" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input">
                            {else}
                                <input type="text" name="order_no" id='order_no' value="{$rs.order_no}" class="spc_input">
                            {/if}
						</li>
						<li>
							{$lang.clientname}： 
							<input type="hidden" name="client_id" id="client_id" value="{$rs.client_id}"/>
							{$rs.client_name}
						</li>
						{/if}                     
						{if $login_user.role_type==C('SELLER_ROLE_TYPE')}						    
							<li>{$lang.return_sale_date}：
							{if C('digital_format')=='eur'}	
							    {if $pass}
								<input type="hidden" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$rs.fmd_return_order_date}"/>{$rs.fmd_return_order_date}
							    {else}
							        <input type="text" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'dd/MM/yy'})" value="{$rs.fmd_return_order_date}"/>__*__
							    {/if}
							{else}
							    {if $pass}
								<input type="hidden" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$rs.fmd_return_order_date}"/>{$rs.fmd_return_order_date}
							    {else}
							        <input type="text" name="return_order_date" id="return_order_date" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy-MM-dd'})" value="{$rs.fmd_return_order_date}"/>__*__
							    {/if}								 
							{/if}
							</li>
                            {if !in_array($rs.return_sale_order_state,array(C('WAIT_ORIGINAL_PACK'),C('FINISH_PROCESSING')))}
                                    {assign var=filter value='2,3,4,5,6,7,8,10'}
                                {else}
                                    {assign var=filter value='2,3,4,5,6,7'}
                                {/if}
							<li>{$lang.return_sale_order_state}：                               
                                {if $pass}				   				   
									<input  type='hidden' name="return_sale_order_state" id="return_sale_order_state" value="{$rs.return_sale_order_state}">{$rs.dd_return_sale_order_state}
								{else}
                                     {select data=C('SELLER_RETURN_SALE_ORDER_STATE') name="return_sale_order_state" id='return_sale_order_state' value=$rs.return_sale_order_state combobox='' empty=true initvalue="1" onchange="isEditService();getSaleOrderInfo(this);hiddenAdd();" filter=$filter}__*__
                                {/if}
							</li> 
						{else} 
							<li>
								{$lang.return_sale_date}： {$rs.fmd_return_order_date}
								<input type="hidden" name="return_order_date" id="return_order_date" value="{$rs.fmd_return_order_date}" class="spc_input">
							</li>							 
                            {if $finish_processing}				 
                                <li>
                                    {$lang.return_sale_order_state}：{$rs.dd_return_sale_order_state}
                                    <input  type='hidden' name="return_sale_order_state" id="return_sale_order_state" value="{$rs.return_sale_order_state}">
                                </li>
                                <li>
                                    {$lang.returned_date}：{$rs.fmd_returned_date}
                                     <input type="hidden" name="returned_date" id="returned_date" value="{$rs.fmd_returned_date}"/>
                                </li>
							{else}
                                <li>
                                    {$lang.return_sale_order_state}：
                                    {if !in_array($rs.return_sale_order_state,array(C('WAIT_ORIGINAL_PACK'),C('FINISH_PROCESSING')))}
                                        {if $rs.return_sale_order_state==C('RETURN_RECEIPT')}					    
                                            {assign var=filter value='4,7,10'}
                                        {else}
                                            {assign var=filter value='2,4,7,10'}
                                        {/if}
                                    {else}
                                        {assign var=filter value='2,4,7'}
                                    {/if}				 
                                    {select data=C('RETURN_SALE_ORDER_STATE') name="return_sale_order_state" id='return_sale_order_state' value=$rs.return_sale_order_state combobox='' empty=true initvalue="1" onchange="isEditService();getSaleOrderInfo(this);hiddenAdd();refuseReason()" filter=$filter}__*__
                                </li>
                                <li {if $rs.returned_date<=0}style="display: none;"{/if}>
                                    {$lang.returned_date}：
                                    <input type="text" name="returned_date" id="returned_date" class="Wdate spc_input" onClick="WdatePicker()" value="{$rs.fmd_returned_date}"/>__*__
                                </li>
                                <li>{$lang.comment}：
                                    <input type="text" name="state_log_comments" id='state_log_comments' class="spc_input">
                                </li>  
                            {/if}
						{/if}	
							{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                            {if $finish_processing}
                                <li>
                                    {$lang.return_reason}：{$rs.dd_return_reason}
                                    <input type="hidden" name="return_reason" id='return_reason' value={$rs.return_reason}>
                                </li>	
                                <li {if $rs.return_reason!=C('RETURN_POSTAGE')||in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID')))}style="display: none"{/if}>
                                   {$lang.return_postage_fee}：
                                   <input type="hidden" name="return_postage_fee" id="return_postage_fee" class="spc_input" value="{$rs.edml_return_postage_fee}">{$rs.currency_no}
                                </li>	
                                {else}
                                <li>
                                    {$lang.return_reason}：
                                    {select data=C('RETURN_REASON') name='return_reason' empty=true value=$rs.return_reason combobox=1 onchange="showReturnPostageFee(this)"}__*__
                                </li>	
                                <li {if $rs.return_reason!=C('RETURN_POSTAGE')}style="display: none"{/if}>
                                   {$lang.return_postage_fee}：
                                   <input type="text" name="return_postage_fee" id="return_postage_fee" class="spc_input" value="{$rs.edml_return_postage_fee}">{$rs.currency_no}
                                </li>		
                            {/if}
                            {else}
                            <li>
								{$lang.return_reason}：{$rs.dd_return_reason}
							</li>
							<li {if $rs.return_reason!=C('RETURN_POSTAGE')}style="display: none"{/if}>
        					   {$lang.return_postage_fee}：
        					   {$rs.return_postage_fee}
        					</li>
							{/if}
                            {if $finish_processing||$pass}
                                <li>
                                    {$lang.return_track_no}：{$rs.return_track_no}
                                    <input type="hidden" id="return_track_no" name="return_track_no" value="{$rs.return_track_no}" class="spc_input"/>				 
                                </li>
                                {else}
                            <li>
                                {$lang.return_track_no}：
                                <input type="text" id="return_track_no" name="return_track_no" value="{$rs.return_track_no}" class="spc_input"/>				 
                            </li>
                            {/if}
                            <div style="float: left">
                                <li>
                                {$lang.return_logistics_no}：
								{if cainiao_return_sale_order($rs)}
									{assign var='is_cainiao_doc' value=true}
								{else}
									{assign var='is_cainiao_doc' value=false}
								{/if}
								{if $is_cainiao_doc || $finish_processing||$pass}
									<input type="hidden" name="return_logistics_no" id="return_logistics_no" class="spc_input" value="{$rs.return_logistics_no}" readonly=true>{$rs.return_logistics_no}
								{else}
									<input type="text" name="return_logistics_no" id="return_logistics_no" class="spc_input" value="{$rs.return_logistics_no}" readonly=true>
								{/if}
                                </li>
                                <li style="display:none">
                                    {$lang.refuse_reason}：
                                    {select data=C('REFUSE_REASON') name="refuse_reason" id="refuse_reason" combobox="1" empty=true value="`$rs.refuse_reason`"}__*__
                                </li>
                            </div>  
                            <div style="clear: both"></div>
                            {if $login_user.role_type != C('SELLER_ROLE_TYPE')}
                                {if $finish_processing}
                                    <div style="float: left">
                                    <li>
                                        {$lang.is_outer_pack_condition}：{$rs.dd_outer_pack}
                                        <input type="hidden" name="outer_pack" id="outer_pack" value={$rs.outer_pack}>
                                    </li>
                                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                            <li></li>
                                    {/if}  
                                    <li {if $rs.outer_pack!=2}style="display: none;"{/if}>{$lang.outer_package}：{$rs.outer_pack_name}
                                        <input type="hidden" id="outer_pack_id" name="outer_pack_id" value="{$rs.outer_pack_id}">
{*                                        <input type="text" id="outer_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={$rs.warehouse_id}"  value="{$rs.outer_pack_name}" jqac />*}
                                    </li>
                                    </div>
                                    <div style="float: left">
                                    <li>
                                        {$lang.is_within_pack_condition}：
                                        <input type="hidden" name="within_pack" id="within_pack" value={$rs.within_pack}>
{*                                        {select data=C('WITHIN_PACK') name="within_pack" id="within_pack" onchange="setWithinPack(this)" value=$rs.within_pack empty=true combobox=1}*}
                                    </li>  
                                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                            <li></li>
                                    {/if}  
                                    <li {if $rs.within_pack!=2}style="display: none;"{/if}>{$lang.within_package}：{$rs.within_pack_name}
                                        <input type="hidden" id="within_pack_id" name="within_pack_id" value="{$rs.within_pack_id}">
{*                                        <input type="text" id="within_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={$rs.warehouse_id}"  value="{$rs.within_pack_name}" jqac />*}
                                    </li> 
                                    </div>
                                    {else}
                                    <div style="float: left">
                                    <li>
                                        {$lang.is_outer_pack_condition}：
                                        {select data=C('OUTER_PACK') name="outer_pack" id="outer_pack" onchange="setOuterPack(this)" value=$rs.outer_pack empty=true combobox=1}
                                    </li>
                                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                            <li></li>
                                    {/if}  
                                    <li {if $rs.outer_pack!=2}style="display: none;"{/if}>{$lang.outer_package}：
                                        <input type="hidden" id="outer_pack_id" name="outer_pack_id" value="{$rs.outer_pack_id}">
                                        <input type="text" id="outer_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={$rs.warehouse_id}"  value="{$rs.outer_pack_name}" jqac />
                                    </li>
                                    </div>
                                    <div style="float: left">
                                    <li>
                                        {$lang.is_within_pack_condition}：
                                        {select data=C('WITHIN_PACK') name="within_pack" id="within_pack" onchange="setWithinPack(this)" value=$rs.within_pack empty=true combobox=1}
                                    </li>  
                                    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                            <li></li>
                                    {/if}  
                                    <li {if $rs.within_pack!=2}style="display: none;"{/if}>{$lang.within_package}：
                                        <input type="hidden" id="within_pack_id" name="within_pack_id" value="{$rs.within_pack_id}">
                                        <input type="text" id="within_pack_name" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" where="warehouse_id={$rs.warehouse_id}"  value="{$rs.within_pack_name}" jqac />
                                    </li> 
                                    </div>
                                {/if}
                            {else}
                                <div style="float: left">
                                <li>
                                    <input type="hidden" id="outer_pack" name="outer_pack" value="{$rs.outer_pack}">
                                    {$lang.is_outer_pack_condition}：{$rs.dd_outer_pack}
                                </li>
                                {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                        <li></li>
                                {/if} 
                                <li {if $rs.outer_pack!=2}style="display: none;"{/if}>
                                    <input type="hidden" id="outer_pack_id" name="outer_pack_id" value="{$rs.outer_pack_id}">
                                    {$lang.outer_package}：{$rs.outer_pack_name}
                                </li>
                                </div>
                                <div style="float: left">
                                <li>
                                    <input type="hidden" id="within_pack" name="within_pack" value="{$rs.within_pack}">
                                    {$lang.is_within_pack_condition}：{$rs.dd_within_pack}
                                </li>  
                                {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
                                        <li></li>
                                {/if} 
                                <li {if $rs.within_pack!=2}style="display: none;"{/if}>
                                    <input type="hidden" id="within_pack_id" name="within_pack_id" value="{$rs.within_pack_id}">
                                    {$lang.within_package}：{$rs.within_pack_name}
                                </li> 
                                </div>
                            {/if}
                            {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE') || $login_user.role_type == 1}
                        	<li>
                        	   <input type="hidden" id="factory_id2" name="factory_id2" value="{$rs.factory_id}">
	                           {$lang.belongs_seller}：{$rs.factory_name}
                	        </li>  
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
            {if in_array($rs.return_sale_order_state,C('SHOW_LOCATION_RETURN_SALE_ORDER_STATE'))&&$login_user.role_type != C('SELLER_ROLE_TYPE')}
                {include file="ReturnSaleOrder/shelves_return_detail.tpl"}
            {else}
                {include file="ReturnSaleOrder/return_detail.tpl"}
            {/if}
		</td>
    	</tr>  
		<tr><th>{$lang.client_info}</th></tr>  
    	<tr>
			<td id="client_info">
				{if $rs.is_related_sale_order == C('IS_RELATED_SALE_ORDER') || $rs.return_sale_order_state != C('RETURN_SALE_ORDER_STATE_PENDING')}
					{include file="Public/client_info_view.tpl"}
				{else}
					{include file="Public/client_info.tpl"}
				{/if}
			</td>
    	</tr> 
		<tr><th>{$lang.other_info}</th></tr>  
    	<tr>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td valign="top" class="t_right" width="20%">{$lang.comments}：</td>
							<td class="t_left" valign="top" width="80%" {if $login_user.role_type != C('SELLER_ROLE_TYPE')}style="line-height: 15px;" {/if}>
								{if $login_user.role_type == C('SELLER_ROLE_TYPE')}
									<textarea id="comments" name="comments" class="textarea_height80">{$rs.edit_comments}</textarea>
								{else}
                                    {$rs.comments}
								{/if}
							</td>    
						</tr>
                        <tr>
                            <td valign="top" class="t_right" width="20%">{$lang.comment}：</td>
                            <td class="t_left" valign="top" width="80%">
                            {if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE')}
                                <textarea id="warehouse_comment" name="warehouse_comment" class="textarea_height80">{$rs.edit_warehouse_comment}</textarea>
                            {elseif $rs.return_sale_order_state == C('PROCESS_COMPLETE')&&$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
				 <textarea id="warehouse_comment" name="warehouse_comment" class="textarea_height80">{$rs.edit_warehouse_comment}</textarea>
                            {else}
				 <textarea id="warehouse_comment" name="warehouse_comment" class="textarea_height80 disabled" readonly="">{$rs.edit_warehouse_comment}</textarea>
                            {/if}
                            </td>
                        </tr>
                        {if $rs.pics}
                        <tr>
                            <td>{$lang.pics}：</td>
                            <td class="t_left">{showFiles from=$rs.pics delete=true}
                            </td>
                        </tr>
                        {/if}
                        <tr>
                            <td></td>
                            <td class="t_left">
                                {upload tocken=$file_tocken sid=$sid type=22  allowTypes="jpg,gif,bmp,png,jpeg,pdf" }
                            </td>
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