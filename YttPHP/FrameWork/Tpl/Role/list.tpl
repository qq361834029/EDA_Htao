{ytt_table 
	show=[
			["value"=>"role_name","title"=>$lang.role_name],
			["value"=>"dd_role_type","title"=>$lang.role_type]
		]
	sort=["role_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}