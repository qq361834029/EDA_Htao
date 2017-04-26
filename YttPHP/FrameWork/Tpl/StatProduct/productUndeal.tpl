<table class="detail_list" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th>{$lang.picking_import_no}</th>
		<th>{$lang.doc_date}</th>
		{stat_product type='th' flow='storage_format' module='instock' value=$lang.unbackshelves_quantity}
	</tr>
	{tr from=$list.list}
        <td>
            <a  target="_blank" href={$item.file_name}> {$item.file_list_no}</a>
        </td>
		<td>{$item.file_list_date}</td>
		{stat_product type='td' flow='storage_format' module='instock' value=$item.dml_quantity class=t_right}
	{/tr}
	<tr class="red">
		<td  class="t_right">{$lang.page_total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.sum_qn class="t_right"}
	</tr>
	<tr class="red">
		<td  class="t_right">{$lang.total}：</td>
		<td></td>
		{stat_product type='td' flow='storage_format' module='instock' value=$list.total.all_sum_qn class=t_right}
	</tr>
</table>