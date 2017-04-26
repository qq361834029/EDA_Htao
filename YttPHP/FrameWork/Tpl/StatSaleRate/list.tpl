

{ytt_table
	from=$list.list
	show=[
		['title'=>$lang.product_no,'value'=>'product_no'],
		['title'=>$lang.product_name,'value'=>'product_name'],
		['title'=>$lang.sale_quantity,'value'=>'dml_out_quantity'],
		['title'=>$lang.in_quantity,'value'=>'dml_in_quantity'],
		['title'=>$lang.stat_sale_rate,'value'=>'dml_percent']
	]
	operate=false
}