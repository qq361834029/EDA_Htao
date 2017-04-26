{ytt_table tr_attr=['class'=>["remind"=>["1"=>"tr_background-color-red"]]] 
	show=[
			["value"=>"out_batch_no","title"=>$lang.out_batch_no,"link"=>["url"=>"OutBatch/view","link_id"=>"id"]],
            ["value"=>"dd_transport_type","title"=>$lang.transport_type],
			["value"=>"transport_start_date","title"=>$lang.transport_start_date],
			["value"=>"dml_quantity","title"=>$lang.internal_quantity],
            ["value"=>"dml_weight","title"=>$lang.bag_weight],
            ["value"=>"dml_review_weight","title"=>$lang.review_weight_g]
		]
	listType='flow'
	flow="out_batch"
	from=$list.list
}

