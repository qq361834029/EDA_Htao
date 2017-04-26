<table class="detail_list" border="0">
	<tr>
		<th width="150">{$lang.flow_name}</th>
		{stat_product type="th" flow="storage_format" value=$lang.quantity width="120"}
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	<!-- 在途数量 -->
	{if $rights.instock}
	<tr>
		<td class="t_right">{$lang.onload_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Onroad/id/$id"|U}','{"onloadQuantity"|title:"StatProduct"}')">{$run_info.onroad_qn}</a></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 头程入库 -->
	{if $rights.adjust}
	<tr>
		<td class="t_right">{$lang.head_way_storage}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Instock/id/$id"|U}','{"productInstock"|title:"StatProduct"}')">{$run_info.instock_storage_qn}</a></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 退货入库 -->
    {if $rights.return}	
    <tr>
		<td class="t_right">{$lang.return_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Return/id/$id"|U}','{"productReturn"|title:"StatProduct"}')">{$run_info.return_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 退货入库(可用) -->
	<tr>
		<td class="t_right">{$lang.module_returnsaleorderstorage}（{$lang.able}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/ReturnStorage/is_sold/1/id/$id"|U}','{"productReturn"|title:"StatProduct"}')">{$run_info.can_sale_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 退货入库（不可用） -->
	<tr>
		<td class="t_right">{$lang.module_returnsaleorderstorage}（{$lang.unable}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/ReturnStorage/is_sold/2/id/$id"|U}','{"productReturn"|title:"StatProduct"}')">{$run_info.no_sale_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 仓库调整 增加 -->
	{if $rights.adjust}
	<tr>
		<td class="t_right">{$lang.adjust_qn}（{$lang.increase}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Adjust/add/1/id/$id"|U}','{"productAdjust"|title:"StatProduct"}',1)">{$run_info.adjust_add}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <!--重新上架-->
    <tr>
		<td class="t_right">{$lang.backshelves_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Backshelves/is_old/1/id/$id"|U}','{"view"|title:"Backshelves"}')">{$run_info.backshelves_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 移仓 增加 -->
	{if $rights.shiftwarehouse}
	<tr>
		<td class="t_right">{$lang.module_shiftwarehouse}（{$lang.increase}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/ShiftWarehouse/add/1/id/$id"|U}','{"view"|title:"shiftwarehouse"}',1)">{$run_info.shift_warehouse_add}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"></td>
	</tr>
	{/if}
	<!-- 销售 -->
	{if $rights.sale}
	<tr>
		<td class="t_right">{$lang.sale_qn}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Sale/out_stock/0/id/$id"|U}','{"productSale"|title:"StatProduct"}')">{$run_info.sale_order_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <tr>
		<td class="t_right">{$lang.picking_will_out}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/OutStock/out_type/2/id/$id"|U}','{"productSale"|title:"StatProduct"}')">{$run_info.picking_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 发货 -->
	<tr>
		<td class="t_right">{$lang.number_of_scans}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/OutStock/out_type/1/id/$id"|U}','{"productDelivery"|title:"StatProduct"}')">{$run_info.out_stock_qn}</a></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 调整 减少 -->
	{if $rights.adjust}
	<tr>
		<td class="t_right">{$lang.adjust_qn}（{$lang.reduce}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Adjust/add/2/id/$id"|U}','{"productAdjust"|title:"StatProduct"}')">{$run_info.adjust_sub}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{/if}
    <!-- 重新上架(旧) -->	
    <tr>
		<td class="t_right">{$lang.old_backshelves}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Backshelves/is_old/2/id/$id"|U}','{"view"|title:"Backshelves"}')">{$run_info.old_backshelves_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <!-- 已出库待收取(可用) -->	
    <tr>
		<td class="t_right">{$lang.return_out}（{$lang.able}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/OutBatch/sold/1/id/$id"|U}','{"view"|title:"OutBatch"}')">{$run_info.out_batch_can_sold_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
    <!-- 已出库待收取(不可用) -->
    <tr>
		<td class="t_right">{$lang.return_out}（{$lang.unable}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/OutBatch/sold/2/id/$id"|U}','{"view"|title:"OutBatch"}')">{$run_info.out_batch_no_sold_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 未重新上架数量 -->
    <tr>
		<td class="t_right">{$lang.unbackshelves_quantity}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Undeal/id/$id"|U}','{"view"|title:"UnBackshelves"}')">{$run_info.unbackshelves_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 丢弃数量 -->    
    <tr>
		<td class="t_right">{$lang.dropped}</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/Dropped/id/$id"|U}','{"view"|title:"dropped"}')">{$run_info.down_and_destory_qn}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<!-- 移仓 减少 -->
	{if $rights.shiftwarehouse}
	<tr>
		<td class="t_right">{$lang.module_shiftwarehouse}（{$lang.reduce}）</td>
		<td class="t_right"><a href="javascript:;" onclick="addTab('{"/StatProduct/productDetail/type/ShiftWarehouse/add/2/id/$id"|U}','{"view"|title:"shiftwarehouse"}',1)">{$run_info.shift_warehouse_sub}</a></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	{/if}
	<!-- 可销售库存 -->
	<tr>
		<th>{$lang.sale_storage}</th>
		{stat_product type='th' flow='warehouse' value=''}
		{stat_product type='th' flow='storage_format' value=$lang.storage_format1}</th>
		<th></th>
		{stat_product type='th' flow='color' value=$lang.color_name}
		{stat_product type='th' flow='size' value=$lang.size_name}
		{stat_product type='th' flow='storage_mantissa' value=$lang.mantissa_2 }
	</tr>
	<tr class="red">
		<td class="t_right">{$lang.total}：</td>
		<td class="t_right" title="{$run_info.instock_storage_qn+$run_info.can_sale_qn+$run_info.adjust_add+$run_info.shift_warehouse_add+$run_info.undeal_qn-$run_info.old_backshelves_qn-$run_info.sale_order_qn-$run_info.out_batch_can_sold_qn-$run_info.adjust_sub-$run_info.shift_warehouse_sub}={$run_info.instock_storage_qn}[{$lang.head_way_storage}]+{$run_info.can_sale_qn}[{$lang.module_returnsaleorderstorage}（{$run_info.is_able}）]+{$run_info.adjust_add}[{$lang.adjust_qn}（{$lang.increase}）]+{$run_info.shift_warehouse_add}[{$lang.shift_warehouse_qn}（{$lang.increase}）]-{$run_info.sale_order_qn}[{$lang.sale_qn}]-{$run_info.old_backshelves_qn}[{$lang.old_backshelves}]-{$run_info.out_batch_can_sold_qn}[{$lang.return_out}（{$run_info.is_able}）]-{$run_info.adjust_sub}[{$lang.adjust_qn}（{$lang.reduce}）-{$run_info.shift_warehouse_sub}[{$lang.shift_warehouse_qn}（{$lang.reduce}）]">
			{$run_info.sale_storage}
		</td>
		{stat_product type='td' flow='warehouse' value=''}
		{stat_product type='td' flow='storage_format' value=''}
		{stat_product type='td' flow='color' value=''}
		{stat_product type='td' flow='size' value=''}
		{stat_product type='td' flow='storage_mantissa' value='' }
	</tr>
	<!-- 实际库存 -->
	<tr>
		<th>{$lang.real_storage}</th>
		{stat_product type='th' flow='warehouse' value=''}
		{stat_product type='th' flow='storage_format' value=$lang.storage_format1}
		<th></th>
		{stat_product type='th' flow='color' value=$lang.color_name}
		{stat_product type='th' flow='size' value=$lang.size_name}
		{stat_product type='th' flow='storage_mantissa' value=$lang.mantissa_2 }
	</tr>
	<tr class="red">
		<td class="t_right">{$lang.total}：</td>
		<td class="t_right" title="{$run_info.instock_storage_qn+$run_info.can_sale_qn+$run_info.adjust_add+$run_info.shift_warehouse_add-$run_info.picking_qn-$run_info.adjust_sub-$run_info.shift_warehouse_sub-$run_info.old_backshelves_qn-$run_info.out_batch_can_sold_qn-$run_info.unbackshelves_qn}={$run_info.instock_storage_qn}[{$lang.head_way_storage}]+{$run_info.can_sale_qn}[{$lang.module_returnsaleorderstorage}（{$run_info.is_able}）]+{$run_info.adjust_add}[{$lang.adjust_qn}（{$lang.increase}）]+{$run_info.shift_warehouse_add}[{$lang.shift_warehouse_qn}（{$lang.increase}）-{$run_info.picking_qn}[{$lang.picking_will_out}]-{$run_info.adjust_sub}[{$lang.adjust_qn}（{$lang.reduce}）]-{$run_info.shift_warehouse_sub}[{$lang.shift_warehouse_qn}（{$lang.reduce}）]-{$run_info.old_backshelves_qn}[{$lang.old_backshelves}]-{$run_info.out_batch_can_sold_qn}[{$lang.return_out}（{$run_info.is_able}）]-{$run_info.unbackshelves_qn}[{$lang.unbackshelves_quantity}]">
			{$run_info.real_storage}
            <a id="auto_show_img" href="javascript:;" pid="{$run_info.id}}" onclick="$.autoShow(this,'RealStorage','')" tabindex="-1">
            <img src="__PUBLIC__/Images/Default/atshow_ico.gif">
            </a>
		</td>
		{stat_product type='td' flow='warehouse' value=''}
		{stat_product type='td' flow='storage_format' value=''}
		{stat_product type='td' flow='color' value=''}
		{stat_product type='td' flow='size' value=''}
		{stat_product type='td' flow='storage_mantissa' value='' }
	</tr>
</table>
















