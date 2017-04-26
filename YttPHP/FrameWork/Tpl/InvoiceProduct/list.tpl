{ytt_table
	show=[
		['title'=>$lang.product_name,'value'=>'product_name'],
		['title'=>$lang.product_no,'value'=>'product_no','type'=>'flow_invoice_product'],
		['title'=>$lang.invoice_ingredient,'value'=>'ingredient','type'=>'flow_invoice_ingredient']
	]
	from=$list.list
}