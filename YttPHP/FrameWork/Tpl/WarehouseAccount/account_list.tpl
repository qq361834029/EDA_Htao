<table class="detail_list" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>{$lang.stock_period}</th>
			<th>{$lang.price_per_unit}</th>
			<th>{$lang.total_stock_quantity}</th>
			<th>{$lang.total_stock_cube}</th>
			<th>{$lang.warehouse_fee}</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{$lang.free_days}</td>
			<td>0.00</td>
			<td>{$rs.free_stock_quantity}</td>
			<td>{$rs.free_stock_cube}</td>
			<td>0.00</td>
		</tr>
		<tr>
			<td>{$lang.within_year}</td>
			<td>{$rs.dml_quarter_warehouse_fee}</td>
			<td>{$rs.quarter_stock_quantity}</td>
			<td>{$rs.quarter_stock_cube}</td>
			<td>{$rs.dml_quarter_warehouse_account}</td>
		</tr>
		<tr>
			<td>{$lang.over_year}</td>
			<td>{$rs.dml_year_warehouse_fee}</td>
			<td>{$rs.year_stock_quantity}</td>
			<td>{$rs.year_stock_cube}</td>
			<td>{$rs.dml_year_warehouse_account}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>&nbsp;</td>
			<td>{$lang.total}:</td>
			<td class="t_center">{$rs.dml_stock_quantity}</td>
			<td class="t_center">{$rs.stock_cube}</td>
			<td class="t_center">{$rs.dml_warehouse_account_fee}</td>
		</tr>
	</tfoot>
</table>


