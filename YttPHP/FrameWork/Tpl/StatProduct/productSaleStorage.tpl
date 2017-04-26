{ytt_table from=$storage_info.sale_storage
	show=[
		['title'=>$lang.color,'value'=>'color_name','type'=>'flow_storage_color'],
		['title'=>$lang.size,'value'=>'size_name','type'=>'flow_storage_size'],
		['title'=>$lang.quantity,'value'=>'dml_quantity'],
		['title'=>$lang.capability,'value'=>'dml_capability'],
		['title'=>$lang.dozen,'value'=>'dml_dozen'],
		['title'=>$lang.real_sale_storage,'value'=>'sale_storage'],
		['title'=>$lang.onroad_storage,'value'=>'onroad_storage','type'=>'flow_onload_storage'],
		['title'=>$lang.sum_sale_storage,'value'=>'all_sale_storage','type'=>'flow_onload_storage'],
		['title'=>$lang.type,'value'=>'dd_mantissa','type'=>'stat_storage_mantissa']
	]
	operate=false
}
