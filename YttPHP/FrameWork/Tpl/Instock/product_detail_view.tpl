<table cellspacing="0" cellpadding="0" class="detail_list">
<thead>
<tr>
	<th class="w60">
        {$lang.serial_id}
	</th>
	<th class="w60">
        {$lang.box_id}
	</th>
	<th class="w120">
		{$lang.box_no}
	</th>
	<th class="w60">
		{$lang.product_id}
	</th>
	<th>
		{$lang.product_no}
	</th>
	<th>
		{$lang.custom_barcode}
	</th>
	<th class="w80">
		{$lang.product_name}
	</th>
    <th>
		{$lang.check_weight_with_unit}
	</th>
    <th>
		{$lang.check_spec_detail}
	</th>
	<th class="w60">
		{$lang.declared_value}
	</th>
	<th>
		{$lang.quantity}
	</th>
	<th>
		{$lang.accepting_quantity}
	</th>
	<th>
		{$lang.in_quantity}
	</th>
	<th>
		{$lang.diff_quantity}
	</th>
</tr>
</thead>
<tbody>
{foreach from=$rs.product item=item name=instock_detail}
<tr>
	<td class="t_left w60">
        {$smarty.foreach.instock_detail.iteration}
	</td>
	<td class="t_left w60">
        {$item.box_id}
	</td>
	<td id="span_box" class="t_left w120">
		{$item.box_no}
	</td>
	<td class="t_left w60">
		{$item.product_id}
	</td>
	<td id="span_product" class="t_left w120">
		{$item.product_no}
	</td>
	<td id="span_custom_barcode" class="t_left">
		{$item.custom_barcode}
	</td>
	<td id="span_product_name" class="t_left w80">
		{$item.product_name}
	</td>
	<td class="t_left w80">
		{$item.dml_check_weight}
	</td>
	<td class="t_left">
		{$item.s_check_cube}
	</td>
	<td class="t_left w60">
		{$item.declared_value}
	</td>
	<td class="t_right w120">
		{$item.dml_quantity}
	</td>
	<td class="t_right">
		{$item.dml_accepting_quantity}
	</td>
	<td class="t_right" width="8%">
		{$item.dml_in_quantity}
	</td>
	{if $item.diff_quantity < 0}
		{assign var=diff_quantity_color value="red"}
	{else}
		{assign var=diff_quantity_color value=""}
	{/if}
	<td class="t_right {$diff_quantity_color}">
		{$item.dml_diff_quantity}
	</td>
</tr>
{/foreach}
</tbody>
<tfoot>
<tr>
	<td class="t_left w60">
	</td>
	<td class="t_left w60">
	</td>
	<td class="t_left w120">
	</td>
	<td class="t_left w60">
	</td>
	<td class="t_left w120">
	</td>
	<td class="t_left">
	</td>
	<td class="t_left w80">
	</td>
	<td class="t_left w80">
		{$rs.product_total.dml_check_weight}
	</td>
	<td class="t_left">
		{$rs.product_total.dml_check_cube}
	</td>
	<td class="t_left w60"></td>
	<td class="t_right w120">
		{$rs.product_total.dml_quantity}
	</td>
	<td class="t_right">
		{$rs.product_total.dml_accepting_quantity}
	</td>
	<td class="t_right">
		{$rs.product_total.dml_in_quantity}
	</td>
	<td class="t_right">
		{$rs.product_total.dml_diff_quantity}
	</td>
</tr>
</tfoot>
</table>