{ytt_table 
	show=[
			["value"=>"shift_warehouse_no","title"=>$lang.shift_warehouse_no,"link"=>["url"=>"ShiftWarehouse/view","link_id"=>"id"]],
			["value"=>"product_counts","title"=>$lang.product_count],
			["value"=>"dml_total_quantity","title"=>$lang.product_sum_quantity],
            ["value"=>"add_real_name","title"=>$lang.operate_person],
			["value"=>"comments","title"=>$lang.comments] 
		]
	listType='flow'
	flow="shiftWarehouse"
	from=$list.list
}

