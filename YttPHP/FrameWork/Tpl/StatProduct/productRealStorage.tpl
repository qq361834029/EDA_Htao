{ytt_table from=$storage_info.storage
	show=[
			['title'=>$lang.warehouse_name,'value'=>'w_name','type'=>'flow_multi_storage'],
			['title'=>$lang.color_name,'value'=>'color_name','type'=>'flow_storage_color'],
			['title'=>$lang.size_name,'value'=>'size_name','type'=>'flow_storage_size'],
			['title'=>$lang.quantity,'value'=>'dml_quantity'],
			['title'=>$lang.capability,'value'=>'dml_capability'],
			['title'=>$lang.dozen,'value'=>'dml_dozen'],
			['title'=>$lang.sum_storage,'value'=>'storage'],
			['title'=>$lang.type,'value'=>'dd_mantissa','type'=>'stat_storage_mantissa']
		]
	operate=false
}
