{ytt_table
	show=[
            ["value"=>"id","title"=>$lang.id,'show'=>false],
			["value"=>"message_time","title"=>$lang.date,"link"=>['url'=>'Message/view',"link_id"=>['id'=>'id']]],
			["value"=>"category_name","title"=>$lang.category_name],
			["value"=>"message_title","title"=>$lang.message_title],
			["value"=>"dd_user_type","title"=>$lang.user_type,'show'=>$is_admin],
			["value"=>"dd_is_read","title"=>$lang.is_read,'show'=>$login_user.user_type >0],
			["value"=>"dd_is_announced","title"=>$lang.is_announced ,'show'=>$is_admin]
		]
	sort=["message_time"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}