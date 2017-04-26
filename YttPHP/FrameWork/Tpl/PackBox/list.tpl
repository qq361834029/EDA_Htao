{ytt_table 
	show=[
			["value"=>"pack_box_no","title"=>$lang.pack_box_no,"link"=>['url'=>'PackBox/view',"link_id"=>"id"]],
            ["value"=>"w_name","title"=>$lang.warehouse_name,"width"=>"10%",'show'=>$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')], 
            ["value"=>"pack_date","title"=>$lang.pack_date],
            ["value"=>"package_name","title"=>$lang.package_name],
			["value"=>"dml_quantity","title"=>$lang.internal_quantity],
			["value"=>"dml_weight","title"=>$lang.bag_weight]
		]
	listType='flow'
	flow="pack_box"
	from=$list.list
}

