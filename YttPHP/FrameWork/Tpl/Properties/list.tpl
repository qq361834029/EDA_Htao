{ytt_table 
	show=[
			["value"=>"properties_no","title"=>$lang.properties_no],
			["value"=>"properties_name","title"=>$lang.properties_name],
			["value"=>"dd_properties_type","title"=>$lang.properties_type],
			["value"=>"dd_role_type","title"=>$lang.role_type]
		]
	sort=["properties_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}