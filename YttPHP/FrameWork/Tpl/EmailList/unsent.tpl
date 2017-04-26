{ytt_table 
	show=[
		["value"=>"dd_email_type","title"=>$lang.email_type],
		["value"=>"comp_name","title"=>$lang.comp_name],
		["value"=>"object_no","title"=>$lang.flow_no,"link"=>['eval'=>'comments_url','title'=>$lang.view]], 
		["value"=>"fmd_insert_time","title"=>$lang.insert_time]
	]
	operate_show=[
		["role"=>'update','class'=>'icon icon-list-email','url'=>'EmailList/edit','onclick'=>'$.editList(this)','title'=>$lang.sent_email],
		["role"=>'delete','class'=>'icon icon-list-del','url'=>'EmailList/delete','onclick'=>'$.cancel(this)']  
	] 
	from=$list.list
	sort=["id"=>["sort_by"=>0,"sort_action"=>"index"]]
}