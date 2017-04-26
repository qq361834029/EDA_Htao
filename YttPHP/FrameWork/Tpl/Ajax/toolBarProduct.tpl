<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="6"><img src="__PUBLIC__/Images/Default/pro_left_top.gif" width="6" height="6" /></td>
		<td colspan="2" background="__PUBLIC__/Images/Default/pro_center_top.gif"></td>
		<td width="10"><img src="__PUBLIC__/Images/Default/pro_right_top.gif" width="10" height="6" /></td>
	</tr>
	<tr>
		<td background="__PUBLIC__/Images/Default/pro_left.gif"></td>
		<td colspan="2" bgcolor="White" align="left" valign="top">
			<table width="402" border="0" cellspacing="0" cellpadding="0" >
				<tr onclick="javascript:$('#toolbarProduct').hide();" style="cursor:pointer">
					<td align="right" bgcolor="#F3F3F3" style="height:15px!important;">
						<span class="psearch_close">&nbsp;</span>
					</td>
				</tr>
			</table>
			<div style="max-height:500px; overflow-y:auto;overflow-x:hidden;">
			<table width="500" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			<td colspan="4" align="left" >
		{if $rs}
			{if $state==2}
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="add_table_autoshow">
				<tr>
					<th>{$lang.product_id}</th>
					<th>{$lang.product_no}</th>
					<th>{$lang.product_id}</th>
					<th>{$lang.product_no}</th>
				</tr>
				{foreach item=row from=$rs}
				<tr>
					{foreach item=item from=$row}
						{$item}
					{/foreach}
				</tr>
				{/foreach}
				</table>
			{else}
			<input type="hidden" id="toolbar_pid" value="{$rs.id}">
	       </td></tr>
			<tr>
				<td colspan="4" >
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="add_table_autoshow">
					<tr>
						<th>{$lang.product_id}</th>
						<th>{$rs.id}</th>
						<th>{$lang.product_no}</th>
						<th>{$rs.product_no}</th>
						<th>{$lang.custom_barcode}</th>
						<th>{$rs.custom_barcode}</th>
					</tr>
					<tr>
						<td>{$lang.belongs_seller}</td>
						<td>{$rs.factory_name}</td>
						<td>{$lang.product_name}</td>
						<td>{$rs.product_name}</td>
						<td>{$lang.weight}</td>
						<td>{$rs.dml_weight}</td>
					</tr>
					<tr>
						<td>{$lang.product_size}</td>
						<td>{$rs.dml_cube_long}</td>
						<td>{$rs.dml_cube_wide}</td>
						<td>{$rs.dml_cube_high}</td>
						<td>{$lang.storage_remind}</td>
						<td>{$rs.warning_quantity}</td>
					</tr>
					</table>
				</td>
			</tr>
		{if $storage}
			<tr>
				<td colspan="4" >
					<div class="fl blue tbold" style="widht:110px; padding-right:5px;">▼{$lang.product_storage_info}</div>
				</td>
			</tr>
			<tr>
				<td colspan="4" >
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="add_table_autoshow">
					<tr>
						<th>{$lang.warehouse_name}</th>
						<th>{$lang.sale_storage}</th>
						<th>{$lang.real_storage}</th>
						<th>{$lang.onroad_storage}</th>
					</tr>
					{foreach item=item2 from=$storage.list}
					<tr>
						<td>{$item2.w_name}</td>
						<td class="t_right">{$item2.dml_sale_quantity}</td>
						<td class="t_right">{$item2.dml_real_quantity}</td>
						<td class="t_right">{$item2.dml_onroad_quantity}</td>
					</tr>
					{/foreach}
					<tr>
						<td>{$lang.row_total}</td>
						<td class="t_right tred">{$storage.total.dml_sale_quantity}</td>
						<td class="t_right tred">{$storage.total.dml_real_quantity}</td>
						<td class="t_right tred">{$storage.total.dml_onroad_quantity}</td>

					</tr>
					</table>
				</td>
			</tr>
		{/if}
	{/if}
	{else}
	<tr>
		<td>{$lang.no_product_storage}</td>
	</tr>
	{/if}
	</table>
	</div>
	</td>
	<td background="__PUBLIC__/Images/Default/pro_right.gif"></td>
	</tr>
	<tr>
		<td width="6"><img src="__PUBLIC__/Images/Default/pro_left_bow.gif" width="6" height="18" /></td>
		<td width="368" background="__PUBLIC__/Images/Default/pro_center_bow.gif"></td>
		<td width="36"><img src="__PUBLIC__/Images/Default/pro_bow_arrow.gif" width="36" height="18" /></td>
		<td width="10"><img src="__PUBLIC__/Images/Default/pro_right_bow.png" /></td>
	</tr>
</table>