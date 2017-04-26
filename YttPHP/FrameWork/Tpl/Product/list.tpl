{ytt_table 
	show=[
			["value"=>"id","title"=>$lang.id,"link"=>['url'=>'Product/view']],
			["value"=>"product_no","title"=>$lang.product_no,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'id']]],
			["value"=>"custom_barcode","title"=>$lang.custom_barcode,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'id']]],
			["value"=>"product_name","title"=>$lang.product_name,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'id']]],
			["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']]],
			["value"=>"s_cube","title"=>$lang.product_size_detail],
			["value"=>"s_weight","title"=>$lang.weight_detail],
			["value"=>"s_check_cube","title"=>$lang.check_product_size_detail],
			["value"=>"s_check_weight","title"=>$lang.check_weight_detail],
			["value"=>"dd_check_status","title"=>$lang.check_status],
			["value"=>"warning_quantity","title"=>$lang.storage_remind],
			["value"=>"s_volume_weight","title"=>$lang.volume_weight_detail] 
		]
	sort=["id"=>["sort_by"=>0, "sort_action"=>"index"],"product_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}