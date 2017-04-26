{ytt_table 
	show=[
		["value"=>"user_name","title"=>$lang.email,"link"=>['url'=>'SellerStaff/view',"link_id"=>['id'=>'id']]],
		["value"=>"real_name","title"=>$lang.employee_name,"link"=>['url'=>'SellerStaff/view',"link_id"=>['id'=>'id']]],
		["value"=>"dd_to_hide","title"=>$lang.is_enable],
		["value"=>"role_name","title"=>$lang.role],
		["value"=>"comp_name","title"=>$lang.belongs_seller,'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE')],
		["value"=>"last_login_time","title"=>$lang.last_login_time]
	]
	sort=["user_name"=>["sort_by"=>1,"sort_action"=>"index"]]
	from=$list.list
}