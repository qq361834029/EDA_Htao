{ytt_table
	show=[
		["value"=>"factory_name","title"=>$lang.belongs_seller,"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']],"width"=>"10%", "show"=>$login_user.role_type != C('SELLER_ROLE_TYPE')],
		["value"=>"comp_name","title"=>$lang.clientname,"width"=>"10%","link"=>['url'=>'Client/view',"link_id"=>['id'=>'id']]],
		["value"=>"consignee","title"=>$lang.consignee,"width"=>"8%"],
		["value"=>"merge_address","title"=>$lang.address],
		["value"=>"post_code","title"=>$lang.post_code,"width"=>"8%"],
		["value"=>"email","title"=>$lang.email,"width"=>"15%"],
		["value"=>"mobile","title"=>$lang.phone,"width"=>"8%"],
		["value"=>"fax","title"=>$lang.fax_no,"width"=>"8%"]
	]
	sort=["comp_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}