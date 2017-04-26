{ytt_table
	show=[
		["value"=>"user_id","title"=>$lang.short_account,"link"=>['url'=>'AmazonAccount/view',"link_id"=>['id'=>'id']]],
		["value"=>"full_user_id","title"=>$lang.amazon_account,"link"=>['url'=>'AmazonAccount/view',"link_id"=>['id'=>'id']]],
		["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']]],
		["value"=>"site_name","title"=>$lang.site_id],
		["value"=>"access_key_id","title"=>$lang.access_key_id],
		["value"=>"secret_acess_key_id","title"=>$lang.secret_acess_key_id],
		["value"=>"merchant_id","title"=>$lang.merchant_id],
		["value"=>"marketplace_id","title"=>$lang.marketplace_id],
		["value"=>"synchrodata","title"=>$lang.synchrodata]
	]
	from=$list.list
	sort=["user_id"=>["sort_by"=>1,"sort_action"=>"index"]]
}