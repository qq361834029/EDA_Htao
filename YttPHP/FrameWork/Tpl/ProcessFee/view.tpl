{wz is_update=$admin==true}
<div class="add_box">
	<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
            <tr>   
                <td class="width10">{$lang.belongs_warehouse}：</td>
                <td class="t_left">{$rs.w_name}</td>
            </tr>
            <tr>   
                <td class="width10">{$lang.order_type}：</td>
                <td class="t_left">
                    {if $rs.order_type>0}
                        {$rs.order_type_name}
                    {else}
                        {$lang.all}
                    {/if}
                </td>
            </tr>
			<tr>
				<td class="width15">{$lang.process_fee_no}：</td>
				<td class="t_left">{$rs.process_fee_no}</td>
			</tr>
			<tr>
				<td>{$lang.process_fee_name}：</td>
				<td class="t_left">{$rs.process_fee_name}</td>
			</tr>
			<tr>
				<td>{$lang.shipping_type}：</td>
				<td class="t_left">{$rs.dd_shipping_type}</td>
			</tr>
			{if $rs.accord_type==1}
			{foreach from=$rs.detail item=item}
			<tr>
				<td>{$lang.weight_interval_with_unit}：</td>
				<td class="t_left">{$item.dml_weight_begin} {$lang.to} {$item.dml_weight_end} {C('WEIGHT_UNIT')}</td>
			</tr>    
			<tr>
				<td>{$lang.process_fee}：</td>
				<td class="t_left">{$item.dml_price}<span class="t_left" id="show_w_currency">{$rs.currency_no}</span></td>
			</tr>
			<tr>
				<td>{$lang.step_price_by_quantity}：</td>
				<td class="t_left">{$item.dml_step_price}<span class="t_left" id="show_w_currency">{$rs.currency_no}</span></td>
			</tr>
            <tr>
				<td>{$lang.max_price}：</td>
				<td class="t_left">{$item.dml_max_price}<span class="t_left" id="show_w_currency">{$rs.currency_no}</span></td>
			</tr>
			{/foreach}
			{else}
				<tr>
					<td colspan=2 style="padding:0 600px 0 120px">{include file="ProcessFee/view_detail.tpl"}</td>
				</tr>
			{/if}
            <tr>
				<td valign="top">{$lang.comments}：</td>
				<td class="t_left">{$rs.edit_comments}</td>
			</tr>
		</tbody>
	</table>
</div>