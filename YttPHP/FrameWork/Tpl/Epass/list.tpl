 {ytt_table 
	show=[
		["value"=>"epass_serial","title"=>$lang.epass_serial],
		["value"=>"epass_no","title"=>$lang.epass_no],
		["value"=>"epass_key","title"=>$lang.epass_key],
		["value"=>"epass_data","title"=>$lang.epass_data]
		]
	sort=["epass_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
} 