{ytt_table 
	show=[
			["value"=>"pv_no","title"=>$lang.pv_no,"link"=>['url'=>'PropertiesValue/view',"link_id"=>['id'=>'id']]],
			["value"=>"pv_name","title"=>$lang.pv_name,"link"=>['url'=>'PropertiesValue/view',"link_id"=>['id'=>'id']]]
		]
	sort=["pv_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
} 