{ytt_table
	show=[
			["value"=>"load_container_no","title"=>$lang.load_container_no,"link"=>["link_id"=>"loadContainer_id","title"=>"查看订单"],"font_class"=>["order_state"=>[2=>"red","1"=>"green"]]],
			["value"=>"container_no","title"=>$lang.container_no],
			["value"=>"dml_total_quantity","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.sum_quantity],
			["value"=>"fmd_load_date","title"=>$lang.load_date],
			["value"=>"fmd_delivery_date","title"=>$lang.delivery_date],
			["value"=>"fmd_expect_arrive_date","title"=>$lang.expect_arrive_date],
			["value"=>"fmd_real_arrive_date","title"=>$lang.real_arrive_date],
			["value"=>"logistics_name","title"=>$lang.trans_comp,'link'=>['url'=>'Logistics/view','link_id'=>['id'=>'logistics_id']]]
		]
	listType='flow'
	flow="loadContainer"
	from=$list.list
}
