{ytt_table
	show=[
		["value"=>"user_id","title"=>$lang.ebay_account,"link"=>['url'=>'EbayAccount/view',"link_id"=>['id'=>'id']]],
		["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']]],
		["value"=>"site","title"=>$lang.site_id],
		["value"=>"synchrodata","title"=>$lang.synchrodata],
		["value"=>"token_status","title"=>$lang.token_status],
		["value"=>"expiration_time","title"=>$lang.token_expiration_time]
	]
	from=$list.list
	sort=["user_id"=>["sort_by"=>1,"sort_action"=>"index"]]
}