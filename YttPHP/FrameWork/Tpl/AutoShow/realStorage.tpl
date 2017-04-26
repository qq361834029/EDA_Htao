<table cellspacing="0" cellpadding="0"  align="center" class="product_table">
    <tbody>    
    <tr>
      <td colspan="2" style="font-size:14px;text-align:left;height:30px;border-bottom:1px #CCCCCC dashed;">{$lang.product_no}：{$rs.product_no}&nbsp;&nbsp;&nbsp;&nbsp;{$lang.custom_barcode}：{$rs.custom_barcode}&nbsp;&nbsp;&nbsp;&nbsp;{$lang.product_name}：{$rs.product_name}</td>

    </tr>
    <tr>
        <td colspan="2" class="t_left"><div class="blue tbold" style="widht:110px; padding-right:5px;float:left;">▼{$lang.real_storage}</div></td>
      </tr>
      {if $storage}
     <tr>
      <td  colspan="2" class="t_left">
		{if $is_factory}
		<table id="index" class="add_table_autoshow" border=0>
			<thead>
				<tr>
					<th width="">{$lang.warehouse_no}</th>
					<th>{$lang.warehouse_name}</th>
					<th width="">{$lang.quantity}</th>
					<th>{$lang.picking_quantity}</th>
				</tr>
			</thead>
			<tbody>
			{foreach item=item from=$storage.list}
				<tr>
					<td width="">{$item.w_no}</td>
					<td width="">{$item.w_name}</td>
					<td width="">{$item.dml_real_storage}</td>
					<td width="">{$item.dml_picking_quantity}</td>
				</tr>
			{/foreach}
			</tbody>
			<tfoot>
				<tr class="red">
					<td width="">{$lang.row_total}：</td>
					<td width="">&nbsp;</td>
					<td width="">{$storage.total.dml_real_storage}</td>
					<td width="">{$storage.total.dml_picking_quantity}</td>
				</tr>				
			</tfoot>
		</table>
		{else}	
			{foreach item=item from=$storage.list key=warehouse_id name=storage}
				<table id="index_{$warehouse_id}" class="add_table_autoshow" border=0>
					<thead>
						<tr>
							<td class="t_left blue total_color">{$lang.warehouse_no}：{$item.0.w_no}</td>
							<td class="t_left blue total_color" colspan="2">{$lang.warehouse_name}：{$item.0.w_name}</td>
						</tr>
						<tr>
							<th width="">{$lang.location_no}</th>
							<th>{$lang.quantity}</th>
							<th>{$lang.picking_quantity}</th>
						</tr>						
					</thead>
					<tbody>
					{foreach item=product from=$item}
						<tr>
							<td width="">{$product.barcode_no}</td>
							<td width="">{$product.dml_real_storage}</td>
							<td width="">{$product.dml_picking_quantity}</td>
						</tr>
					{/foreach}
					</tbody>
					<tfoot>
						<tr class="red">
							<td width="">{if $is_warehouser}{$lang.row_total}{else}{$lang.subtotal}{/if}：</td>
							<td width="">
								{assign var=dml_real_storage value="dml_warehouse_id_`$warehouse_id`_real_storage"}
								{$storage.total.$dml_real_storage}
							</td>
							<td width="">
								{assign var=dml_picking_quantity value="dml_warehouse_id_`$warehouse_id`_picking_quantity"}
								{$storage.total.$dml_picking_quantity}
							</td>							
						</tr>	
						{if !$is_warehouser && $smarty.foreach.storage.last}
						<tr class="red">
							<td>{$lang.total}：</td>
							<td>{$storage.total.dml_real_storage}</td>
							<td>{$storage.total.dml_picking_quantity}</td>
						</tr>						
						{/if}
					</tfoot>
				</table>
			{/foreach}			
		{/if}
      </td>
    </tr>  
     {else}
	    <tr>
        <td colspan="2" class="t_center">&nbsp;</td>
      </tr>
      {/if} 
    </tbody>
  </table>
