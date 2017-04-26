{ytt_table 
	show=[
		["value"=>"user_name","title"=>$lang.user_name,"link"=>['url'=>'User/view',"link_id"=>['id'=>'id']]],
		["value"=>"real_name","title"=>$lang.real_name,"link"=>['url'=>'User/view',"link_id"=>['id'=>'id']]],
                ["value"=>"company_id","title"=>$lang.id,"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'company_id']],"show"=>$smarty.post.query.user_type == C('SELLER_ROLE_TYPE')],
                ["value"=>"basic_name_en","title"=>$lang.basic_name_en,"show"=>$smarty.post.query.user_type == C('SELLER_ROLE_TYPE')],
		["value"=>"dd_user_type","title"=>$lang.user_type],
		["value"=>"role_name","title"=>$lang.belong_role]
	]
	sort=["user_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}