<table  class="list" border="1"> 
	<tr>
		<th rowspan="1">{$lang.product_id}</th> 
		<th rowspan="1">{$lang.product_no}</th> 
		<th rowspan="1">{$lang.undeal_quantity}</th>
		<th rowspan="1">{$lang.warehouse_location}</th>
	</tr> 
	{tr from=$list.list }
		{td }
			{$item.product_id}
		{/td}
		{td }
			{$item.product_no}
		{/td} 
		{td }
			{$item.dml_undeal_quantity}
		{/td} 
		{td }
			{$item.barcode_no}
		{/td} 
	{/tr} 
</table>
<br><br> 
