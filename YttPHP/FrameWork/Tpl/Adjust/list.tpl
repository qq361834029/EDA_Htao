{ytt_table 
	show=[
			["value"=>"adjust_no","title"=>$lang.adjust_no,"link"=>["link_id"=>"adjust_id"]],
            ["value"=>"warehouse_no","title"=>$lang.warehouse_no],
			["value"=>"product_counts","title"=>$lang.product_count],
			["value"=>"dml_total_quantity","title"=>$lang.product_sum_quantity],
            ["value"=>"add_real_name","title"=>$lang.operate_person],
			["value"=>"comments","title"=>$lang.comments] 
		]
	listType='flow'
	flow="adjust"
	from=$list.list
}

