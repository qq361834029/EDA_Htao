{ytt_table
	show=[
		['title'=>$lang.product_no,'value'=>'product_no','type'=>'flow_invoice_product'],
		['title'=>$lang.product_name,'value'=>'product_name'],
		['title'=>$lang.sale_quantity,'value'=>'dml_out_quantity'],
		['title'=>$lang.sale_price,'value'=>'dml_avg_out_price'],
		['title'=>$lang.in_price,'value'=>'dml_avg_in_price'],
		['title'=>$lang.profit_money,'value'=>'dml_profit_money']
	]
	from=$list.list
	operate	= false
}