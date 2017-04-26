 
{ytt_table

	show=[
		["value"=>"id","title"=>$lang.id,"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'id']],"width"=>"3%"],
		["value"=>"email","title"=>$lang.email,"width"=>"10%"],
		["value"=>"comp_name","title"=>$lang.factory_name,"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'id']],"width"=>"7%"],
		["value"=>"dd_to_hide","title"=>$lang.is_enable,"width"=>"3%"],
		["value"=>"contact","title"=>$lang.contact,"width"=>"7%"],
		["value"=>"mobile","title"=>$lang.phone,"width"=>"8%"],
        ["value"=>"basic_name_en","title"=>$lang.basic_name_en,"width"=>"8%"],
        ["value"=>"warehouse_connection_qq","title"=>$lang.warehouse_connection_qq,"width"=>"8%"],
        ["value"=>"brt_account_no","title"=>$lang.brt_account_no,"width"=>"8%"],
		["value"=>"enabled_warehouse","title"=>$lang.enabled_warehouse,"width"=>"8%"],
        ["value"=>"create_time","title"=>$lang.registration_time,"width"=>"8%"],
		["value"=>"comments","title"=>$lang.comments,"width"=>"8%"],
		["value"=>"fmd_last_login_time","title"=>$lang.last_login_time,"width"=>"9%"],
		["value"=>"dd_merger","title"=>$lang.order_combin,"width"=>"3%"],
		["value"=>"package_discount","title"=>$lang.package_discount,"width"=>"5%"],
		["value"=>"process_discount","title"=>$lang.process_discount,"width"=>"5%"]
	]
	sort=["id"=>["sort_by"=>0,"sort_action"=>"index"],"comp_name"=>["sort_action"=>"index"],"mobile"=>["sort_action"=>"index"]]
	from=$list.list
}