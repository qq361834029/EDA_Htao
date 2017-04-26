{ytt_table 
	show=[
			["value"=>"init_storage_no","title"=>$lang.init_no,"link"=>["url"=>'InitStorage/view',"link_id"=>["id"=>"init_storage_id"]]],
			["value"=>"dml_total_quantity","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.init_total],
			["value"=>"dml_money","title"=>$lang.total_money],
			["value"=>"fmd_init_storage_date","title"=>$lang.init_date]
		]
	listType='flow'
	flow="initStorage"
	from=$list.list
}

