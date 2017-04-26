{ytt_table
	show=[
			["value"=>"load_container_no","title"=>$lang.load_container_no,"link"=>["url"=>"LoadContainer/view","link_id"=>"id","title"=>$lang.view]],
			["value"=>"container_no","title"=>$lang.container_no],
			["value"=>"fmd_load_date","title"=>$lang.load_date],
			["value"=>"fmd_delivery_date","title"=>$lang.delivery_date],
			["value"=>"fmd_expect_arrive_date","title"=>$lang.arrive_date],
			["value"=>"dml_sum_qn","title"=>$lang.total_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sun_quantity","title"=>$lang.lc_quantity],
			["value"=>"logistics_name","title"=>$lang.trans_comp,'link'=>['url'=>'Logistics/view','link_id'=>['id'=>'logistics_id']]]
		]
	listType='flow'
	flow="loadContainer"
	from=$list.list
	operate_show=[
		["role"=>'insert','class'=>'icon icon-list-edit','url'=>'Instock/add']
	]
}