 {ytt_table 
	show=[
			["value"=>"w_name","title"=>$lang.warehouse_name],
			["value"=>"w_no","title"=>$lang.warehouse_no],
			["value"=>"dml_quantity","title"=>$lang.quantity],
			["value"=>"dml_real_storage","title"=>$lang.sum_quantity]
		]
	sort=["color_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	operate=false 
	from=$list.list
} 