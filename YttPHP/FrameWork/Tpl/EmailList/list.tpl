{ytt_table 
	show=[
		["value"=>"dd_email_type","title"=>$lang.email_type],
		["value"=>"comp_name","title"=>$lang.comp_name],
		["value"=>"object_no","title"=>$lang.flow_no,"link"=>['eval'=>'comments_url','title'=>$lang.view]], 
		["value"=>"fmd_insert_time","title"=>$lang.insert_time],
		["value"=>"fmd_send_time","title"=>$lang.sent_time]
	]
	
	from=$list.list
	operate=false
	sort=["id"=>["sort_by"=>0,"sort_action"=>"index"]]
}