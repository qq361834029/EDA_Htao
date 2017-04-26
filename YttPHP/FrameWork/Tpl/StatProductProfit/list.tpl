<table  class="list" border="1">
	<tr>
		<th>{$lang.product_no}</th>
		<th>{$lang.product_name}</th>
		<th>{$lang.pre_storage_money}</th>
		<th>{$lang.instock_money}</th>
		<th>{$lang.sale_money}</th>
		<th>{$lang.special_money}</th>
		<th>{$lang.final_storage_money}</th>
		<th>{$lang.cross_money}</th>
	</tr>
	{tr from=$list.list row_total=['befor_money'=>'','in_stock_money'=>'','sale_money'=>'','adjust_money'=>'','stock_money'=>'','profit_money'=>'']}
		{td title="" link=["url"=>"StatProduct/view","link_id"=>["search_form"=>"1","product_id"=>$item.product_id]]}
			{$item.product_no}
		{/td}
		{td title=$lang.page_total}
			{$item.product_name}
		{/td}
		{td class="t_right"}
			{$item.dml_befor_money}
		{/td}
		{td class="t_right"}
			{$item.dml_in_stock_money}
		{/td}
		{td class="t_right"}
			{$item.dml_sale_money}
		{/td}
		{td class="t_right"}
			{$item.dml_adjust_money}
		{/td}
		{td class="t_right"}
			{$item.dml_stock_money}
		{/td}
		{td class="t_right"}
			{$item.dml_profit_money}
		{/td}
	{/tr}
</table>
<br><br>