{ytt_table
	show=[
		['title'=>$lang.invoice_no,'value'=>'invoice_no','link'=>['url'=>'InvoiceIn/view','link_id'=>'id']],
		['title'=>$lang.supplier,'value'=>'factory_name'],
		['title'=>$lang.invoice_date,'value'=>'fmd_invoice_date'],
		['title'=>$lang.sum_quantity,'value'=>'dml_sum_qn'],
		['title'=>$lang.goods_cost,'value'=>'dml_row_money'],
		['title'=>'IVA','value'=>'dml_iva'],
		['title'=>$lang.iva_cost,'value'=>'dml_iva_cost'],
		['title'=>$lang.total_money,'value'=>'dml_money'],
		['title'=>$lang.pay_type,'value'=>'dd_paid_type']
	]
	from=$list.list
	listType="flow"
}