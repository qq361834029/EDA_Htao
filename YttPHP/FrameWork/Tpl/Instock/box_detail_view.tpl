<table cellspacing="0" cellpadding="0" class="detail_list">
<thead>
<tr>
	<th class="w60">
        {$lang.box_id}
	</th>
	<th class="w60">
		{$lang.box_no}
	</th>
	<th>
		{$lang.spec_detail}
	</th>
	<th class="w60">
		{$lang.weight_with_unit}
	</th>
	<th class="w180">
		{$lang.comments}
	</th>
	<th>
		{$lang.check_spec_detail}
	</th>
    <th class="w80">
		{$lang.check_weight_with_unit}
	</th>
    <th class="w60">
		{$lang.check_status}
	</th>
	<th class="w180">
		{$lang.check_comments}
	</th>
</tr>
</thead>
<tbody>
{foreach from=$rs.box item=item}
<tr>
	<td class="t_left w60">
        {$item.id}
	</td>
	<td class="t_left w60">
        {$item.box_no}
	</td>
	<td>
		{$item.s_cube}
	</td>
	<td class="w60">
		{$item.weight}
	</td>
	<td class="w180">
        {$item.edit_comments}
	</td>
	<td>
		{$item.s_check_cube}
	</td>
	<td class="w80">
		{$item.check_weight}
	</td>
	<td class="w60">
        {$item.dd_check_status}
	</td>
	<td class="w180">
        {$item.edit_check_comments}
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
	<td>
		{$rs.box_total.dml_cube}
	</td>
	<td class="w60">
		{$rs.box_total.dml_weight}
	</td>
	<td class="w180">
	</td>
	<td>
		{$rs.box_total.dml_check_cube}
	</td>
	<td class="w80">
		{$rs.box_total.dml_check_weight}
	</td>
	<td class="w60">
	</td>
	<td class="w180">
	</td>
</tr>
</tfoot>
</table>
